<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Seat;
use App\Enums\PnrStatus;


class Pnr extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => PnrStatus::class,
    ];
    
    public function seats(){
        return $this->hasMany(Seat::class);
    }

    public function airline(){
        return $this->belongsTo(AirLine::class);
    }

}
