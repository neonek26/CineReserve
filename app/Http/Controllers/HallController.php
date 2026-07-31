<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use Illuminate\Http\Request;

class HallController extends Controller
{
    public function index()
    {
        $halls = Hall::withCount('seats')->get();

        return view('halls.index', compact('halls'));
    }

    public function show(Hall $hall)
    {
        $hall->load('seats');

        return view('halls.show', compact('hall'));
    }
}