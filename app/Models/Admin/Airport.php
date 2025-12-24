<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AirLineStatus;

class Airport extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => AirLineStatus::class,
    ];
}
