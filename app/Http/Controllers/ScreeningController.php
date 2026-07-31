<?php

namespace App\Http\Controllers;

use App\Models\Screening;
use Illuminate\Http\Request;

class ScreeningController extends Controller
{
    public function index()
    {
        $screenings = Screening::with(['movie', 'hall'])
            ->where('start_time', '>=', now())
            ->orderBy('start_time', 'asc')
            ->get();

        return view('screenings.index', compact('screenings'));
    }

    public function show(Screening $screening)
    {
        $screening->load(['movie', 'hall']);

        return view('screenings.show', compact('screening'));
    }
}