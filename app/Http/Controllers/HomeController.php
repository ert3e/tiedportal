<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Project;
use App\Models\QuoteRequest;
use App\Models\Task;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \Xero;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use \Breadcrumbs;
use \Permissions;
use \Auth;

class HomeController extends Controller
{
    public function index() {

        switch( Auth::user()->type ) {
            case 'user':
                return $this->_userIndex();

            case 'customer':
                return $this->_customerIndex();

            case 'supplier':
                return $this->_supplierIndex();
        }
    }

    public function _userIndex() {
        $start_date = Carbon::now()->subDays(7);
        // $projects = Project::active()->mine()->whereNull('start_date')->orWhere('start_date', '>=', $start_date)->orderBy('due_date', 'DESC')->paginate(10);
        $projects = Project::mine()->Uncomplete()->whereNull('start_date')->orWhere('start_date', '>=', $start_date)->orderBy('due_date', 'DESC')->paginate(10);

        $tasks = Task::assigned()->open()->uncompleted()->orderBy('due_date', 'ASC')->orderBy('priority', 'DESC')->paginate(10);

        $priorities = Task::$priorities;

        $events = Permissions::has('timeline', 'view') ? Event::orderBy('date', 'DESC')->take(20)->get() : false;

        return view('home.index', compact('projects', 'tasks', 'priorities', 'events'));
    }

    public function _supplierIndex() {
        $quote_requests = Auth::user()->supplier->quoteRequests()->pending()->get();
        return view('supplier.home.index', compact('quote_requests'));
    }

    public function _customerIndex() {
        $tickets = Auth::user()->tickets()->orderBy('updated_at', 'DESC')->get();
        return view('customer.home.index', compact('tickets'));
    }
}
