<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\BookingStatus;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => BookingStatus::class,
    ];

    public function pnr(){
        return $this->belongsTo(Pnr::class);
    }

    public function customers(){
        return $this->hasMany(Customer::class);
    }
}
