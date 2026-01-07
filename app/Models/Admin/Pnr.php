<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Seat;
use App\Enums\PnrStatus;
use App\Models\User;
use Carbon;


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

    public function departure(){
        return $this->belongsTo(Airport::class, 'departure_id', 'id');
    }

    public function arrival(){
        return $this->belongsTo(Airport::class, 'arrival_id', 'id');
    }

    public function return_airline(){
        return $this->belongsTo(AirLine::class, 'return_airline_id', 'id');
    }

    public function return_departure(){
        return $this->belongsTo(Airport::class, 'return_departure_id', 'id');
    }

    public function return_arrival(){
        return $this->belongsTo(Airport::class, 'return_arrival_id', 'id');
    }

    // public function baggages()
    // {
    //     return $this->belongsToMany(Baggage::class, 'baggage_pnr', 'pnr_id', 'baggage_id');
    // }

    public function pnr_passenger()
    {
        return $this->belongsToMany(PnrPassenger::class, 'pnr_passengers', 'pnr_id', 'passenger_type_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function getSeatAvailableAttribute()
    {
        return $this->seats()
            ->where('is_sale', 1)
            ->count();
    }

    public function getDepartureDateTimeAttribute()
    {
        return \Carbon\Carbon::parse($this->departure_date.$this->departure_time)->format('d-M-y H:i');
    }

    public function getArrivalDateTimeAttribute()
    {
        return \Carbon\Carbon::parse($this->arrival_date.$this->arrival_time)->format('d-M-y H:i');
    }

    public function getReturnDepartureDateTimeAttribute()
    {
        return \Carbon\Carbon::parse($this->return_departure_date.$this->return_departure_time)->format('d-M-y H:i');
    }

    public function getReturnArrivalDateTimeAttribute()
    {
        return \Carbon\Carbon::parse($this->return_arrival_date.$this->return_arrival_time)->format('d-M-y H:i');
    }

}
