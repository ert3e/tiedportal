<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Session\TokenMismatchException;

class SessionController extends Controller
{
    public function ping() {
        return response()->json(['success' => true]);
    }
}
