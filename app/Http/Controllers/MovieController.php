<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    public function index() {

        $response = Http::get('https://www.omdbapi.com/?s=star&apikey='. env('API_KEY'));


        $movie_fetch = json_decode($response->body());

        $movies = array();
        $movie_list = $movie_fetch->Search;
        foreach($movie_list as $movie) {
            $details = Http::get('https://www.omdbapi.com/?i='.$movie->imdbID.'&apikey='.env('API_KEY'));
            $movies[] = json_decode($details->body());
        }



        return view('account', compact('movies'));
    }

    public function find_movies(Request $request) {

        dd($request->input('movie'));
        return view('search');
    }

    public function show() {
        return view('favourites');
    }
}
