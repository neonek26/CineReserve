<?php

namespace App\Http\Controllers;

use App\Models\Screening;
use App\Models\Reservation;
use App\Models\Seat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function show(Screening $screening)
    {
        $screening->load(['movie', 'hall']);

        $seats = Seat::where('hall_id', $screening->hall_id)->get();

        $reservedSeatIds = Reservation::where('screening_id', $screening->id)
            ->pluck('seat_id')
            ->toArray();

        return view('reservations.show', compact('screening', 'seats', 'reservedSeatIds'));
    }

    public function store(Request $request, Screening $screening)
    {
        $request->validate([
            'seats' => 'required|array',
            'seats.*' => 'exists:seats,id',
        ]);

        foreach ($request->seats as $seatId) {
            $exists = Reservation::where('screening_id', $screening->id)
                ->where('seat_id', $seatId)
                ->exists();

            if (!$exists) {
                Reservation::create([
                    'user_id' => Auth::id(),
                    'screening_id' => $screening->id,
                    'seat_id' => $seatId,
                ]);
            }
        }

        return redirect()->route('profile.show')->with('success', 'Rezervace byla úspěšně vytvořena!');
    }
}