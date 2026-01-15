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

    public function middle_arrival(){
        return $this->belongsTo(Airport::class, 'middle_arrival_id', 'id');
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

    public function middle_return_arrival(){
        return $this->belongsTo(Airport::class, 'return_middle_arrival_id', 'id');
    }

    public function return_arrival(){
        return $this->belongsTo(Airport::class, 'return_arrival_id', 'id');
    }

    public function pnr_passenger()
    {
        return $this->belongsToMany(PnrPassenger::class, 'pnr_passengers', 'pnr_id', 'passenger_type_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function getSeatIsSaleAttribute()
    {
        return $this->seats()
            ->where('is_sale', 1)
            ->count();
    }

    public function getSeatAvailableAttribute()
    {
        return $this->seats()
            ->where('is_available', 1)
            ->count();
    }

    public function getSeatIsSoldAttribute()
    {
        return $this->seats()
            ->where('is_sold', 1)
            ->count();
    }

    public function getDepartureDateTimeAttribute()
    {
        return \Carbon\Carbon::parse($this->departure_date.$this->departure_time)->format('d-M-y H:i');
    }

    public function getMiddleArrivalDateTimeAttribute()
    {
        return \Carbon\Carbon::createFromFormat('d-M-y H:i', $this->getDepartureDateTimeAttribute())
        ->setTimeFromTimeString($this->middle_arrival_time)->format('d-M-y H:i');
    }

    public function getMiddleReturnArrivalDateTimeAttribute()
    {
        return \Carbon\Carbon::createFromFormat('d-M-y H:i', $this->getReturnDepartureDateTimeAttribute())
        ->setTimeFromTimeString($this->middle_return_arrival_time)->format('d-M-y H:i');
    }

    public function getMiddleDepartureDateTimeAttribute()
    {
        $datetime = \Carbon\Carbon::createFromFormat('d-M-y H:i', $this->getMiddleArrivalDateTimeAttribute());
        $duration = $this->rest_time;
        [$hours, $minutes] = explode(':', $duration);
        $result = $datetime
            ->addHours($hours)
            ->addMinutes($minutes);
        return $result->format('d-M-y H:i');
    }

    public function getMiddleReturnDepartureDateTimeAttribute()
    {
        $datetime = \Carbon\Carbon::createFromFormat('d-M-y H:i', $this->getMiddleReturnArrivalDateTimeAttribute());
        $duration = $this->return_rest_time;
        [$hours, $minutes] = explode(':', $duration);
        $result = $datetime
            ->addHours($hours)
            ->addMinutes($minutes);
        return $result->format('d-M-y H:i');
    }

    public function getFirstDurationAttribute(){
        $start = \Carbon\Carbon::createFromFormat('H:i:s', $this->departure_time);
        $end   = \Carbon\Carbon::createFromFormat('H:i', $this->middle_arrival_time);

        $diff = $start->diff($end);

        return $diff->format('%H'.'h %I'.'m');
    }

    public function getFirstReturnDurationAttribute(){
        $start = \Carbon\Carbon::createFromFormat('H:i:s', $this->return_departure_time);
        $end   = \Carbon\Carbon::createFromFormat('H:i', $this->middle_return_arrival_time);

        $diff = $start->diff($end);

        return $diff->format('%H'.'h %I'.'m');
    }

    public function getSecondDurationAttribute(){
        $start = \Carbon\Carbon::createFromFormat('d-M-y H:i', $this->getMiddleDepartureDateTimeAttribute());
        $end   = \Carbon\Carbon::createFromFormat('d-M-y H:i', $this->getArrivalDateTimeAttribute());

        $diff = $start->diff($end);

        return $diff->format('%H'.'h %I'.'m');
    }

    public function getSecondReturnDurationAttribute(){
        $start = \Carbon\Carbon::createFromFormat('d-M-y H:i', $this->getMiddleReturnDepartureDateTimeAttribute());
        $end   = \Carbon\Carbon::createFromFormat('d-M-y H:i', $this->getReturnArrivalDateTimeAttribute());

        $diff = $start->diff($end);

        return $diff->format('%H'.'h %I'.'m');
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

    public function getDepartureTimeHourAttribute(){
        $departureTime = explode(':', $this->departure_time);
        return $departureTime[0];
    }

    public function getDepartureTimeMinuteAttribute(){
        $departureTime = explode(':', $this->departure_time);
        return $departureTime[1];
    }

    public function getArrivalTimeHourAttribute(){
        $arrivalTime = explode(':', $this->arrival_time);
        return $arrivalTime[0];
    }

    public function getArrivalTimeMinuteAttribute(){
        $arrivalTime = explode(':', $this->arrival_time);
        return $arrivalTime[1];
    }

    public function getReturnDepartureTimeHourAttribute(){
        $departureTime = explode(':', $this->return_departure_time);
        return (isset($departureTime[0])) ? $departureTime[0] : null;
    }

    public function getReturnDepartureTimeMinuteAttribute(){
        $departureTime = explode(':', $this->return_departure_time);
        return (isset($departureTime[1])) ? $departureTime[1] : null;
    }

    public function getReturnArrivalTimeHourAttribute(){
        $arrivalTime = explode(':', $this->return_arrival_time);
        return (isset($arrivalTime[0])) ? $arrivalTime[0] : null;
    }

    public function getReturnArrivalTimeMinuteAttribute(){
        $arrivalTime = explode(':', $this->return_arrival_time);
        return (isset($arrivalTime[1])) ? $arrivalTime[1] : null;
    }

}
