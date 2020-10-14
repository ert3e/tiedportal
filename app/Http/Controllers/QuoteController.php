<?php

namespace App\Http\Controllers;

use App\Jobs\SendQuoteRequestEmail;
use App\Models\Component;
use App\Models\Cost;
use App\Models\QuoteRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;
use \Breadcrumbs;
use App\Http\Requests;
use \DB;
use \Auth;
use \PDF;

class QuoteController extends Controller
{
    public function index() {
        Breadcrumbs::push(trans('quotes.title'), route('quotes.index'));
    }

    public function request($project) {
        Breadcrumbs::push(trans('quotes.title'), route('quotes.index'));
        Breadcrumbs::push(trans('quotes.request'), route('quotes.request', $project->id));

        $types = $project->types()->lists('id');

        $suppliers = Supplier::whereHas('projectTypes', function($q) use($types) {
            $q->whereIn('id', $types);
        })->orderBy('name')->get();

        $other_suppliers = Supplier::whereNotIn('id', $suppliers->pluck('id'))->orderBy('name', 'DESC')->get();

        return view('quotes.request', compact('project', 'suppliers', 'other_suppliers'));
    }

    public function send(Request $request, $project) {

        Breadcrumbs::push(trans('quotes.title'), route('quotes.index'));
        Breadcrumbs::push(trans('quotes.request'), route('quotes.request', $project->id));
        
        $suppliers = Supplier::whereIn('id', $request->input('supplier', []))->get();
        $components = Component::whereIn('id', $request->input('component', []))->get();
        $message = $request->input('message', '');

        DB::transaction(function() use($suppliers, $project, $message, $components) {

            foreach( $suppliers as $supplier ) {
                $quote_request = QuoteRequest::create([
                    'status'    => 'pending',
                    'message'   => $message
                ]);
                $quote_request->supplier()->associate($supplier);
                $quote_request->project()->associate($project);
                $quote_request->user()->associate(Auth::user());
                $quote_request->save();
                
                // Save components
                foreach( $components as $component ) {
                    $quote_request->components()->attach($component);
                }

                $this->dispatch(new SendQuoteRequestEmail($quote_request));
            }
        });

        return redirect()->route('projects.details', $project->id)->with('success', 'Your quote request has been sent!');
    }

    public function details($quote) {
        Breadcrumbs::push(trans('quotes.title'), route('quotes.index'));
        Breadcrumbs::push($quote->project->name, route('projects.details', $quote->project->id));
        Breadcrumbs::push(sprintf('%s / (%s)', $quote->supplier->name, $quote->reference), route('quotes.details', $quote->id));

        $supplier = $quote->supplier;
        $project = $quote->project;
        return view('quotes.details', compact('quote', 'supplier', 'project'));
    }
    
    public function accept(Request $request, $quote) {

        $rules = [
            'value'         => 'required|numeric',
            'cost'          => 'required|numeric',
            'invoice_date'  => 'required_with:invoiced|date_format:d/m/Y'
        ];

        $this->validate($request, $rules);

        $description = $request->input('description', '');
        $cost = $request->input('cost', 0);
        $value = $request->input('value', 0);
        $invoiced = $request->has('invoiced');
        $invoice_date = $request->input('invoice_date', null);
        $invoice_reference = $request->input('invoice_reference', '');
        
        // Create a cost object
        $cost = new Cost([
            'cost'              => $cost,
            'value'             => $value,
            'invoiced'          => $invoiced,
            'invoice_date'      => $invoice_date,
            'invoice_reference' => $invoice_reference,
            'description'       => $description
        ]);

        $cost->project()->associate($quote->project);
        $cost->supplier()->associate($quote->supplier);
        $cost->quote()->associate($quote);
        $cost->save();

        return redirect()->route('projects.details', $quote->project->id)->with('success', 'Cost added successfully!');
    }
}
