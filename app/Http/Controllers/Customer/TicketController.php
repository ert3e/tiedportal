<?php

namespace App\Http\Controllers\Customer;

use App\AppTraits\HasNotes;
use App\Events\TicketAddedEvent;
use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\Ticket;
use \Breadcrumbs;
use App\Http\Requests;
use \DB;
use \FieldRenderer;
use \Auth;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    use HasNotes;

    public function index() {

    }

    public function create() {
        $severities = Ticket::$severity_levels;
        $projects = [0 => 'None'] + Auth::user()->customer->projects()->lists('name', 'id')->toArray();
        return view('customer.tickets.create', compact('severities', 'projects'));
    }

    public function store(Request $request) {

        $rules = [
            'project_id'    => 'exists:projects,id,customer_id,' . Auth::user()->customer->id,
            'subject'       => 'required',
            'description'   => 'required'
        ];

        $this->validate($request, $rules);

        $ticket = DB::transaction(function() use($request) {
            $ticket = new Ticket([
                'severity'      => $request->input('severity', 1),
                'subject'       => $request->input('subject'),
                'project_id'    => $request->input('project_id', 0),
                'status'        => 'pending'
            ]);
            
            $ticket->user()->associate(Auth::user());
            $ticket->customer()->associate(Auth::user()->customer);
            $ticket->save();

            $note = Note::create([
                'content'       => $request->input('description')
            ]);

            $ticket->notes()->attach($note->id);
            
            return $ticket;
        });

        \Event::fire(new TicketAddedEvent($ticket));

        return redirect()->route('customer.tickets.details', $ticket->id)->with('success', 'Ticket submitted. We will be in touch shortly.');
    }

    public function details($ticket) {
        $notes = $ticket->notes()->orderBy('created_at', 'DESC')->get();
        $notes->pop();
        return view('customer.tickets.details', compact('ticket', 'notes'));
    }
}