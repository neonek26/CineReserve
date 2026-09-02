<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\Seat;
use Illuminate\Http\Request;

class HallController extends Controller
{
    public function index()
    {
        $halls = Hall::withCount('seats')->get();
        return view('halls.index', compact('halls'));
    }

    public function create()
    {
        return view('halls.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rows' => 'required|integer|min:1|max:20',
            'seats_per_row' => 'required|integer|min:1|max:30',
        ]);

        $hall = Hall::create([
            'name' => $validated['name'],
        ]);

        for ($row = 1; $row <= $validated['rows']; $row++) {
            for ($seat = 1; $seat <= $validated['seats_per_row']; $seat++) {
                Seat::create([
                    'hall_id' => $hall->id,
                    'row_number' => $row,
                    'seat_number' => $seat,
                ]);
            }
        }

        return redirect()->route('home')->with('success', 'Sál byl úspěšně vytvořen a sedadla vygenerována!');
    }
}