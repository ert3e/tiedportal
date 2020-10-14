<?php

namespace App\Http\Controllers;

use App\AppTraits\HasEditableAttributes;
use App\AppTraits\UploadsMedia;
use App\Models\User;
use \Breadcrumbs;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Customer;
use \DB;
use Illuminate\Support\Str;
use \Mail;
use \Hash;

class ContactController extends Controller
{
    use UploadsMedia;
    use HasEditableAttributes;

    function __construct() {
        parent::__construct();
        Breadcrumbs::push(trans('contacts.title'), route('contacts.index'));
    }

    public function index(Request $request) {

        $term = '';
        if( $request->has('search') ) {

            $term = $request->get('search');

            $contacts = Contact::where(DB::raw('CONCAT_WS(\' \', `first_name`, `last_name`)'), 'LIKE', '%' . $term . '%')
                ->orWhereHas('customers', function($q) use($term) {
                    $q->where('name', 'LIKE', '%' . $term . '%');
                });

        } else {
            $contacts = Contact::orderBy('first_name', 'ASC');
        }

        $types = \App\Models\ContactType::all();


        if($request->has('download')){
            $contacts = $contacts->orderBy('first_name', 'ASC')->get();
            $view = view('contacts.csv', compact('contacts'))->render();
            $headers['Content-Disposition'] = "attachment; filename=". str_slug(('contacts list '. $term), '_') .".csv";
            $headers['Content-Length'] = strlen($view);
            return response($view, 200, $headers);
        }
        $contacts = $contacts->orderBy('first_name', 'ASC')->paginate(25)->appends($request->all());

        return view('contacts.index', compact('contacts', 'term', 'types'));
    }

    public function indexDownload(Request $request)
    {
        return $this->index($request);
    }

    public function details($contact) {
        Breadcrumbs::push(sprintf('%s %s', $contact->first_name, $contact->last_name), route('contacts.details', $contact->id));
        return view('contacts.details', compact('contact'));
    }

    public function delete($contact) {
        $contact->delete();
        return redirect()->route('contacts.index');
    }

    public function createUser($contact) {

        // generate a username
        $username = sprintf('%s%s', strtolower($contact->first_name), strtolower($contact->last_name));

        // Does this user exist?
        $count = User::where('username', $username)->count();

        if( $count )
            $username .= ($count+1);

        return view('contacts.users.create', compact('contact', 'username'));
    }

    public function storeUser(Request $request, $contact) {

        $rules = [
            'username'  => 'required|unique:users,username'
        ];

        $this->validate($request, $rules);

        if( is_object($contact->supplier) ) {
            $type = 'supplier';
        } else if( is_object($contact->customer) ) {
            $type = 'customer';
        } else {
            abort(400);
        }

        $user = User::create([
            'username'      => $request->input('username'),
            'email'         => $contact->email,
            'password'      => '',
            'role_id'       => 0,
            'type'          => $type,
            'last_login'    => null
        ]);

        $contact->user()->associate($user)->save();

        // Setup a password reset
        $token = Str::random(60);
        DB::table('password_resets')->insert([
            ['email' => $user->email, 'token' => $token]
        ]);

        $data = [
            'token'     => $token,
            'user'      => $user,
            'content'   => $request->input('message', false)
        ];

        Mail::queue('emails.user.created', $data, function ($message) use($user) {
            $message->to($user->email, sprintf('%s %s', $user->first_name, $user->last_name));
        });

        return redirect()->route('users.details', $user->id);
    }
}
