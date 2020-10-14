<?php

namespace App\Http\Controllers;

use App\AppTraits\HasAttachments;
use App\AppTraits\HasContacts;
use App\AppTraits\HasEditableAttributes;
use App\AppTraits\HasNotes;
use App\AppTraits\UploadsMedia;
use App\AppTraits\HasAddresses;
use App\Models\ContactType;
use App\Models\CustomerType;
use App\Models\LeadSource;
use App\Models\Task;
use Illuminate\Http\Request;
use JeroenDesloovere\VCard\VCard;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use \Breadcrumbs;
use \DB;

class CustomerController extends Controller
{
    use UploadsMedia;
    use HasAddresses;
    use HasContacts;
    use HasEditableAttributes;
    use HasNotes;
    use HasAttachments;

    function __construct() {
        parent::__construct();
        Breadcrumbs::push(trans('customers.title'), route('customers.index'));
    }

    public function index(Request $request) {

        Breadcrumbs::push(trans('customers.title'), route('customers.index'));

        $customer_types = CustomerType::orderBy('name')->lists('name', 'id');

        $term = '';
        if( $request->has('search') ) {

            $term = $request->get('search');
            $customers = Customer::customers()->where('name', 'LIKE', '%' . $term . '%')
                ->orWhereHas('contacts', function($q) use($term) {
                    // This has to be nested or the inner join become an "OR" and returns all results
                    $q->where(function($q) use($term) {
                        $q->where('email', 'LIKE', $term . '%')->orWhere(DB::raw('CONCAT_WS(\' \', `first_name`, `last_name`)'), 'LIKE', '%' . $term . '%');
                    });
                });

        } else {
            $customers = Customer::customers();
        }

        $type = 'customer';

        $lead_sources = LeadSource::orderBy('name', 'ASC')->lists('name', 'id');

        $customers = $customers->orderBy('name', 'ASC')->paginate(25)->appends($request->all());

        return view('customers.index', compact('customers', 'customer_types', 'term', 'type', 'lead_sources'));
    }

    public function leads(Request $request) {

        Breadcrumbs::push(trans('leads.title'), route('leads.index'));

        $customer_types = CustomerType::orderBy('name')->lists('name', 'id');

        $term = '';
        if( $request->has('search') ) {

            $term = $request->get('search');
            $customers = Customer::leads()->where('name', 'LIKE', '%' . $term . '%')
                ->orWhereHas('contacts', function($q) use($term) {
                    // This has to be nested or the inner join become an "OR" and returns all results
                    $q->where(function($q) use($term) {
                        $q->where('email', 'LIKE', $term . '%')->orWhere(DB::raw('CONCAT_WS(\' \', `first_name`, `last_name`)'), 'LIKE', '%' . $term . '%');
                    });
                })
                ->orderBy('name', 'ASC')
                ->paginate(25);

        } else {
            $customers = Customer::leads()->orderBy('name', 'ASC')->paginate(25);
        }

        $type = 'lead';

        $lead_sources = LeadSource::orderBy('name', 'ASC')->lists('name', 'id');

        return view('customers.index', compact('customers', 'customer_types', 'term', 'lead_sources', 'type'));
    }

    public function store(Request $request) {

        $rules = [
            'name'          => 'required',
            'category'      => 'exists:customer_types,id'
        ];

        $this->validate($request, $rules);

        $customer = Customer::create($request->only(['name', 'description', 'type']));

        if( $request->has('category') ) {
            $customer_category = CustomerType::find($request->input('category'));
            $customer->category()->associate($customer_category);
            $customer->save();
        }

        return redirect()->route('customers.details', [$customer->id]);
    }

    public function details($customer) {
        Breadcrumbs::push($customer->name, route('customers.details', $customer->id));
        $customer_types = CustomerType::orderBy('name')->get();
        $contact_types = ContactType::orderBy('name')->lists('name', 'id');
        $notes = $customer->notes()->orderBy('updated_at', 'DESC')->get();
        $tasks = Task::whereIn('id', $customer->projects()->select('id')->get()->pluck('id'))->where('status', 'open')->get();
        return view('customers.details', compact('customer', 'customer_types', 'contact_types', 'notes', 'tasks'));
    }

    public function delete($customer) {
        $customer->delete();
        return redirect()->route('customers.index');
    }

    public function autocomplete($term) {

        $customers = Customer::where('name', 'LIKE', '%' . $term . '%')
            ->orWhereHas('contacts', function($q) use($term) {
                // This has to be nested or the inner join become an "OR" and returns all results
                $q->where(function($q) use($term) {
                    $q->where('email', 'LIKE', $term . '%')->orWhere(DB::raw('CONCAT_WS(\' \', `first_name`, `last_name`)'), 'LIKE', '%' . $term . '%');
                });
            })
            ->select(['id', 'name', 'description'])
            ->orderBy('name', 'ASC')
            ->take(15)
            ->get();

        return response()->json($customers);
    }

    public function downloadContacts($customer)
    {

        // $contactTypes = DB::raw('SELECT * FROM contact_types')->get()->toArray();
        $contactTypesTemp = DB::table('contact_types')->get();
        $contactTypes = array();
        foreach($contactTypesTemp as $type)
            $contactTypes[$type->id] = $type;

        // dd('dada');
        // define vcard

        $vCardArray = array();
        foreach ($customer->contacts as $c){
            // dd($c);
            $vcard = new VCard();
            $firstname = $c->first_name;
            $lastname = $c->last_name;
            $additional = '';
            $prefix = '';
            $suffix = '';
            $vcard->addName($lastname, $firstname, $additional, $prefix, $suffix);
            $vcard->addCompany($customer->name);

            if((int)$c->contact_type_id > 0)
                $vcard->addJobtitle($contactTypes[$c->contact_type_id]->name);

            if(trim($c->email))
                $vcard->addEmail($c->email);

            if(trim($c->mobile))
                $vcard->addPhoneNumber($c->mobile, 'PREF;MOBILE');

            if(trim($c->mobile))
                $vcard->addPhoneNumber($c->telephone, 'WORK');

            if($c->media_id > 0  && is_file($c->imageUrl())){
                $path = $c->imageUrl();
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                $vcard->addPhoto($base64);
            }

            $vCardArray[] = $vcard->getOutput();
        }
        $vCard = implode("",$vCardArray);
        $headers = $vcard->getHeaders(true);
        $headers['Content-Disposition'] = "attachment; filename=". str_slug($customer->name, '_') .".vcf";
        $headers['Content-Length'] = strlen($vCard);
        // dd($headers);

        return \Response::make(
            $vCard,
            200,
            $headers
        );
    }
}
