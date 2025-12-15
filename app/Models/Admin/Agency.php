<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AgencyStatus;

class Agency extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => AgencyStatus::class,
    ];

}
