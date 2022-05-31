<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\FavouriteMovie;

class MovieController extends Controller
{
    public function index() {

        $response = Http::get('https://www.omdbapi.com/?s=star&apikey='. env('API_KEY'));

        $search_value = 'star';
        $movie_fetch = json_decode($response->body());

        $movies = array();
        $favourite_ids = array();
        $favourite_movies = FavouriteMovie::all();

        foreach ($favourite_movies as $favourite_movie) {
            $favourite_ids[] = $favourite_movie->ImdbID;
        }

        $movie_list = $movie_fetch->Search ?? null;;

        foreach ($movie_list as $movie) {
            $details = Http::get('https://www.omdbapi.com/?i='.$movie->imdbID.'&apikey='.env('API_KEY'));
            $movies[] = json_decode($details->body());
        }

        return view('account', compact('movies', 'search_value', 'favourite_ids'));
    }

    public function find_movies(Request $request) {

        $search_value = $request->input('searchvalue');

        $response = Http::get('https://www.omdbapi.com/?s='.$search_value.'&apikey='. env('API_KEY'));
        $movie_fetch = json_decode($response->body());

        $movies = array();

        $favourite_ids = array();
        $favourite_movies = FavouriteMovie::all();

        foreach ($favourite_movies as $favourite_movie) {
            $favourite_ids[] = $favourite_movie->ImdbID;
        }

        $movie_list = $movie_fetch->Search ?? null;

        if($movie_list) {
            foreach($movie_list as $movie) {
                $details = Http::get('https://www.omdbapi.com/?i='.$movie->imdbID.'&apikey='.env('API_KEY'));
                $movies[] = json_decode($details->body());
            }
        }

        return view('search', compact('movies', 'search_value', 'favourite_ids'));
    }

    public function add_favourite(Request $request)
    {
        $storeMovie = $request->validate([
            'Plot' => 'required',
            'Year' => 'required',
            'Title' => 'required',
            'Poster' => 'required',
            'ImdbID' => 'required'
        ]);

        FavouriteMovie::firstOrCreate($storeMovie);

        return $this->find_movies($request);

    }

    public function random_movies() {

        $movies_array = array();
        while(count($movies_array) <= 10) {
            $random_id = 'tt'.rand(1917588, 7999980);
            $response = Http::get('https://www.omdbapi.com/?i='.$random_id.'&type=movie&apikey='. env('API_KEY'));
            $movie_fetch = json_decode($response->body());
            if (isset($movie_fetch->Title)) {
                $movies_array[] = $movie_fetch;
            }
        }

        return view('random', compact('movies_array'));

    }

    public function show_favourites() {

        $favourite_movies = FavouriteMovie::all();

        return view('favourites', compact('favourite_movies'));
    }
}
