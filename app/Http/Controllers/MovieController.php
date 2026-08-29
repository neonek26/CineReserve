<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::with(['screenings' => function ($query) {
            $query->where('starts_at', '>=', now())->orderBy('starts_at', 'asc');
        }])->get();

        return view('movies.index', compact('movies'));
    }

    public function show(Movie $movie)
    {
        $movie->load(['screenings' => function ($query) {
            $query->where('starts_at', '>=', now())->orderBy('starts_at', 'asc');
        }]);

        return view('movies.show', compact('movie'));
    }
}