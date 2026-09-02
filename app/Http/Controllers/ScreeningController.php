<?php

namespace App\Http\Controllers;

use App\Models\Screening;
use App\Models\Movie;
use App\Models\Hall;
use Illuminate\Http\Request;

class ScreeningController extends Controller
{
    public function index()
    {
        $screenings = Screening::with(['movie', 'hall'])->get();
        return view('screenings.index', compact('screenings'));
    }

    public function create()
    {
        $movies = Movie::all();
        $halls = Hall::all();
        return view('screenings.create', compact('movies', 'halls'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'hall_id' => 'required|exists:halls,id',
            'starts_at' => 'required|date',
            'price' => 'required|numeric|min:0',
        ]);

        Screening::create($validated);

        return redirect()->route('home')->with('success', 'Promítání bylo úspěšně naplánováno!');
    }
}