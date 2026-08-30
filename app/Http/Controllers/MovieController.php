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
    public function create()
{
    return view('movies.create');
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required|integer|min:1',
            'genre' => 'required|string|max:100',
        ]);

        Movie::create($validated);

        return redirect()->route('home')->with('success', 'Film byl úspěšně přidán!');
    }
    public function destroy(Movie $movie)
    {
        $movie->delete();

        return redirect()->route('home')->with('success', 'Film byl úspěšně smazán!');
    }
}