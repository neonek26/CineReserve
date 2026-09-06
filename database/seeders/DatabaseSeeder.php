<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Movie;
use App\Models\Hall;
use App\Models\Seat;
use App\Models\Screening;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@cinereserve.cz',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        $user = User::create([
            'name' => 'Andrej Fiala',
            'email' => 'skib@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        $hall1 = Hall::create([
            'name' => 'Sál 1 (Velký)',
            'rows_count' => 4,
            'seats_per_row' => 5,
        ]);

        $hall2 = Hall::create([
            'name' => 'Sál 2 (VIP)',
            'rows_count' => 3,
            'seats_per_row' => 4,
        ]);

        for ($row = 1; $row <= 4; $row++) {
            for ($seat = 1; $seat <= 5; $seat++) {
                Seat::create([
                    'hall_id' => $hall1->id,
                    'row_number' => $row,
                    'seat_number' => $seat,
                ]);
            }
        }

        for ($row = 1; $row <= 3; $row++) {
            for ($seat = 1; $seat <= 4; $seat++) {
                Seat::create([
                    'hall_id' => $hall2->id,
                    'row_number' => $row,
                    'seat_number' => $seat,
                ]);
            }
        }

        $movie1 = Movie::create([
            'title' => 'Obsession',
            'description' => 'Psychologický thriller plný nečekaných zvratů, touhy a napětí.',
            'duration' => 115,
            'genre' => 'Thriller',
            'poster_url' => 'https://images.unsplash.com/photo-1509198397868-475647b2a1e5?w=800&auto=format&fit=crop',
        ]);

        $movie2 = Movie::create([
            'title' => 'Oppenheimer',
            'description' => 'Příběh J. Roberta Oppenheimera a vývoje první atomové bomby.',
            'duration' => 180,
            'genre' => 'Drama / Biografický',
            'poster_url' => 'https://images.unsplash.com/photo-1440404653325-ab127d49abc1?w=800&auto=format&fit=crop',
        ]);

        $movie3 = Movie::create([
            'title' => 'Umamusume: Pretty Derby – Beginning of a New Era',
            'description' => 'Jungle Pocket se účastní závodů Twinkle Series a snaží se překonat své soupeře v boji o titul nejrychlejší koňské dívky.',
            'duration' => 108,
            'genre' => 'Anime / Sportovní / Drama',
            'poster_url' => 'https://images.unsplash.com/photo-1578632767115-351597cf2477?w=800&auto=format&fit=crop',
        ]);

        Screening::create([
            'movie_id' => $movie1->id,
            'hall_id' => $hall1->id,
            'starts_at' => now()->addDays(1)->setTime(18, 00),
            'price' => 180.00,
        ]);

        Screening::create([
            'movie_id' => $movie2->id,
            'hall_id' => $hall1->id,
            'starts_at' => now()->addDays(1)->setTime(20, 30),
            'price' => 200.00,
        ]);

        Screening::create([
            'movie_id' => $movie3->id,
            'hall_id' => $hall2->id,
            'starts_at' => now()->addDays(2)->setTime(19, 00),
            'price' => 220.00,
        ]);
    }
}