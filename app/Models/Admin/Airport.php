<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AirportStatus;

class Airport extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => AirportStatus::class,
    ];
}
