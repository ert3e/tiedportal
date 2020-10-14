<?php

namespace App\Http\Controllers\Supplier;

use App\AppTraits\HasNotes;
use App\AppTraits\UploadsMedia;
use App\Http\Controllers\Controller;
use App\Jobs\SendQuoteRequestDeclineEmail;
use App\Jobs\SendQuoteRequestQuotedEmail;
use App\Models\Quote;
use \Breadcrumbs;
use App\Http\Requests;
use \DB;
use \Auth;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    use UploadsMedia;
    use HasNotes;

    protected function getMediaTypes() {
        return []; // Accept all media
    }

    public function index() {
        $supplier = Auth::user()->supplier;

        $pending = $supplier->quoteRequests()->pending()->orderBy('created_at', 'DESC')->get();
        $submitted = $supplier->quoteRequests()->submitted()->orderBy('created_at', 'DESC')->get();

        Breadcrumbs::push('Quotes', route('supplier.quotes.index'));

        return view('supplier.quotes.index', compact('pending', 'submitted'));
    }

    public function view($quote_request) {
        Breadcrumbs::push('Quotes', route('supplier.quotes.index'));
        Breadcrumbs::push($quote_request->project->name, route('supplier.quotes.view', $quote_request->id));

        $project = $quote_request->project;
        $project_types = implode(', ', $project->types->pluck('name')->toArray());

        $notes = $quote_request->notes()->orderBy('updated_at', 'DESC')->get();

        return view('supplier.quotes.view', compact('quote_request', 'project', 'project_types', 'notes'));
    }

    public function submit(Request $request, $quote_request) {

        $rules = [
            'status'    => 'required|in:submitted,declined'
        ];

        $this->validate($request, $rules);

        $quote = DB::transaction(function() use($quote_request, $request) {
            
            $quote_request->update([
                'supplier_message'  => $request->input('message'),
                'status'            => $request->input('status')
            ]);

            if( $quote_request->status == 'submitted' ) {

                // Include the price and and files
                $quote = Quote::create([
                    'cost'          => $request->input('cost', 0),
                    'includes_vat'  => $request->input('includes_vat', false),
                    'reference'     => $request->input('reference', ''),
                    'message'       => $request->input('message', '')
                ]);

                $quote->project()->associate($quote_request->project);
                $quote->supplier()->associate(Auth::user()->supplier);
                $quote->quoteRequest()->associate($quote_request);
                $quote->save();
                
                // Any files?
                if( $request->hasFile('media') ) {
                    $media = $this->attachMedia($request);
                    $quote->media()->save($media);
                }

                return $quote;
            }
        });

        if( $quote_request->status == 'declined' ) {
            $this->dispatch(new SendQuoteRequestDeclineEmail($quote_request));
            return redirect()->route('supplier.quotes.index')->with('success', 'Your response has been received.');
        } else {
            $this->dispatch(new SendQuoteRequestQuotedEmail($quote_request, $quote));
            return redirect()->back()->with('success', 'Your response has been received.');
        }
    }
}