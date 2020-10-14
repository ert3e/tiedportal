<?php

namespace App\Http\Controllers;

use App\AppTraits\HasEditableAttributes;
use App\AppTraits\UploadsMedia;
use App\Models\Contact;
use App\Models\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \Auth;
use App\Models\User;
use \Breadcrumbs;
use \Permissions;
use \Mail;
use \Hash;
use \DB;

class UserController extends Controller
{
    use UploadsMedia;
    use HasEditableAttributes;

    function __construct() {
        parent::__construct();
        Breadcrumbs::push(trans('settings.title'), route('settings.index'));
        Breadcrumbs::push(trans('users.title'), route('users.index'));
    }

    public function index() {
        $users = User::with('contact')->get();
        return view('users.index', compact('users'));
    }

    public function profile() {
        return redirect()->route('users.details', Auth::user()->id);
    }

    public function details($user = false) {

        if( !$user )
            $user = Auth::user();

        // Ensure we have a contact record
        if( !is_object($user->contact) ) {
            $contact = Contact::create([]);
            $contact->user()->associate($user)->save();
            $user->contact = $contact;
        }

        Breadcrumbs::push(trans(sprintf('%s %s', $user->contact->first_name, $user->contact->last_name)), route('users.details', $user->id));


        $roles = Role::orderBy('name', 'ASC')->get();
        $can_change_password = Auth::user()->id == $user->id || Permissions::has('users', 'edit');
        return view('users.profile', compact('user', 'roles', 'can_change_password'));
    }

    public function store(Request $request) {

        $this->validate($request, User::$rules);
        $user = User::create($request->all());

        if( $request->has('generate_password') ) {
            $password = str_random(10);
            $user->password = Hash::make($password);
            $user->save();

            Mail::send('emails.welcome', ['user' => $user, 'password' => $password], function ($m) use ($user) {
                $m->from('noreply@portal.blush.digital', 'blush.manager');
                $m->to($user->email, sprintf('%s %s', $user->first_name, $user->last_name))->subject('Welcome!');
            });
        }

        return redirect()->route('users.details', $user->id);
    }

    public function autocomplete(Request $request, $term = '') {

        // $term = $request->input('query', $term); // unnecessary
        $user_list = User::user()->has('contact')
            ->where(function($q) use($term) {
                $q->where('email', 'LIKE', '%' . $term . '%')
                    ->orWhereHas('contact', function($q) use($term) {
                        $q->where(DB::raw('CONCAT_WS(\' \', `first_name`, `last_name`)'), 'LIKE', '%' . $term . '%');
                    });
            })
            ->take(15)
            ->get();

        $users = [];
        foreach( $user_list as $user ) {
            $name = sprintf('%s %s', $user->contact->first_name, $user->contact->last_name);
            if(trim($name) == '')
                $name = sprintf('%s', $user->username);
            $users[] = [
                'id'    => $user->id,
                'name'  => $name
            ];
        }

        $users = collect($users)->sortBy('text')->values()->all();

        return response()->json($users);
    }

    public function delete(Request $request, $user)
    {
        $user->role_id = 99;
        $user->save();
        // $user->delete();
        return redirect()->route('users.index');
    }
}
