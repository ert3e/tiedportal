<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Foundation\Auth\ResetsPasswords;

class LoginController extends Controller
{
    use ThrottlesLogins, ResetsPasswords;

    protected $redirectPath;

    function __construct() {
        $this->redirectPath = route('login');
    }

    public function index() {
        return view('login.index');
    }

    public function login(Request $request) {

        $rules = [
            'username'  => 'required',
            'password'  => 'required'
        ];

        $this->validate($request, $rules);

        if( Auth::attempt(['username' => $request->input('username'), 'password' => $request->input('password')], $request->has('remember')) ) {
            Auth::user()->update(['last_login' => Carbon::now()]);
            return redirect()->intended(route('home.index'));
        }

        return redirect()->back()->with('error', 'Login failed. Please check your username and password');
    }

    public function logout() {
        Auth::logout();

        return redirect()->route('login');
    }

    public function getEmail() {
        return view('login.forgot');
    }

    public function postEmail(Request $request) {
        $this->validate($request, ['email' => 'required|email']);

        $response = Password::sendResetLink($request->only('email'), function (Message $message) {
            $message->subject($this->getEmailSubject());

        });

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return redirect()->back()->with('success', 'An email has been sent to your email address. Please click the link and follow the instructions to reset your password');

            case Password::INVALID_USER:
                return redirect()->back()->withErrors(['email' => trans($response)]);
        }
    }

    public function showResetForm(Request $request, $token = null) {
        if (is_null($token)) {
            return $this->getEmail();
        }

        $email = $request->input('email');

        if (view()->exists('login.reset')) {
            return view('login.reset')->with(compact('token', 'email'));
        }

        return view('login.reset')->with('token', $token);
    }

    protected function getEmailSubject() {
        return 'Password Reset';
    }
}
