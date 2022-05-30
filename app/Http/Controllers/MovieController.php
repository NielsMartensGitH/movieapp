<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    public function index() {

        $response = Http::get('https://www.omdbapi.com/?s=star&apikey='. env('API_KEY'));


        $movies = json_decode($response->body());

        dd($movies);


        return view('account');
    }

    public function show() {
        return view('favourites');
    }
}
