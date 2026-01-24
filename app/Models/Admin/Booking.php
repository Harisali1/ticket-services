<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\BookingStatus;
use App\Models\User;

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

    public function return_pnr(){
        return $this->belongsTo(Pnr::class, 'return_pnr_id', 'id');
    }

    public function customers(){
        return $this->hasMany(Customer::class);
    }

    public function user(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function payable(){
        return $this->belongsTo(User::class, 'paid_by', 'id');
    }

    public function approve(){
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }

    public function getBookingDateAttribute()
    {
        return \Carbon\Carbon::parse($this->created_at)->format('d-M-y H:i');
    }

    public function getFareLimitDateAttribute()
    {
        return \Carbon\Carbon::parse($this->created_at->addDay())->format('d-M-y H:i');
    }

    // public function 
}
