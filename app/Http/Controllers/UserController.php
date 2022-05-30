<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        return view('account');
    }

    public function show() {
        return view('favourites');
    }
}
