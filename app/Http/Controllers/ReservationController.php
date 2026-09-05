<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Screening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['screening.movie', 'screening.hall', 'seat'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('reservations.index', compact('reservations'));
    }

    public function create(Screening $screening)
    {
        $screening->load(['movie', 'hall.seats']);

        $reservedSeatIds = Reservation::where('screening_id', $screening->id)
            ->pluck('seat_id')
            ->toArray();

        return view('reservations.create', compact('screening', 'reservedSeatIds'));
    }

    public function store(Request $request, Screening $screening)
    {
        $validated = $request->validate([
            'seat_ids' => 'required|array|min:1',
            'seat_ids.*' => 'exists:seats,id',
        ]);

        $alreadyReserved = Reservation::where('screening_id', $screening->id)
            ->whereIn('seat_id', $validated['seat_ids'])
            ->exists();

        if ($alreadyReserved) {
            return back()->withErrors(['seat_ids' => 'Jedno nebo více z vybraných sedadel je již rezervováno.']);
        }

        foreach ($validated['seat_ids'] as $seatId) {
            Reservation::create([
                'user_id' => Auth::id(),
                'screening_id' => $screening->id,
                'seat_id' => $seatId,
                'status' => 'pending',
            ]);
        }

        return redirect()->route('reservations.index')->with('success', 'Rezervace byla úspěšně vytvořena!');
    }

    public function pay(Reservation $reservation)
    {
        if (Auth::id() !== $reservation->user_id) {
            abort(403);
        }

        $reservation->update([
            'status' => 'paid',
        ]);

        return back()->with('success', 'Platba proběhla úspěšně!');
    }

    public function destroy(Reservation $reservation)
    {
        if (Auth::id() !== $reservation->user_id && !Auth::user()->is_admin) {
            abort(403);
        }

        $reservation->delete();

        return back()->with('success', 'Rezervace byla úspěšně zrušena.');
    }

    public function adminIndex()
    {
        $reservations = Reservation::with(['user', 'screening.movie', 'screening.hall', 'seat'])
            ->latest()
            ->get();

        return view('admin.reservations.index', compact('reservations'));
    }
}