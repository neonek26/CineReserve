<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'rows_count', 'seats_per_row'];

    public function screenings()
    {
        return $this->hasMany(Screening::class);
    }
}