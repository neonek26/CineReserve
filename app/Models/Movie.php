<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'duration',
        'genre',
    ];

    public function screenings()
    {
        return $this->hasMany(Screening::class);
    }

    protected static function booted()
    {
        static::deleting(function ($movie) {
            $movie->screenings()->delete();
        });
    }
}