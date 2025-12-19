<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AirLineStatus;


class AirLine extends Model
{
    use HasFactory;

    protected $table = 'air_lines';

    protected $guarded = [];

    protected $casts = [
        'status' => AirLineStatus::class,
    ];


}
