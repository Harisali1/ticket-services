<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Seat;
use App\Enums\PnrStatus;
use App\Models\User;
use Carbon;
use DateTime;


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
    
    public function getSeatIsReservedAttribute()
    {
        return $this->seats()
            ->where('is_reserved', 1)
            ->count();
    }

    public function getDepartureDateTimeAttribute()
    {
        return \Carbon\Carbon::parse($this->departure_date.$this->departure_time)->format('d-M-y H:i');
    }

    public function getMiddleArrivalDateTimeAttribute()
    {

        if($this->middle_arrival_time != null){
            $departure = \Carbon\Carbon::createFromFormat('d-M-y H:i',$this->getDepartureDateTimeAttribute());

            $arrival = $departure->copy()->setTimeFromTimeString($this->middle_arrival_time);

            // agar arrival time chhota hai departure se → next day
            if ($arrival->lt($departure)) {
                $arrival->addDay();
            }

            return $arrival->format('d-M-y H:i');
        }
        
    }

    public function getMiddleReturnArrivalDateTimeAttribute()
    {
        return \Carbon\Carbon::createFromFormat('d-M-y H:i', $this->getReturnDepartureDateTimeAttribute())
        ->setTimeFromTimeString($this->middle_return_arrival_time)->format('d-M-y H:i');
    }

    public function getMiddleDepartureDateTimeAttribute()
    {

        //  $middleDeparture = \Carbon\Carbon::createFromFormat('d-M-y H:i', $this->getMiddleArrivalDateTimeAttribute())
        // ->setTimeFromTimeString($this->rest_time)->format('d-M-y H:i');
        // return $middleDeparture;
        if($this->getMiddleArrivalDateTimeAttribute() != null){
            $departure = \Carbon\Carbon::createFromFormat('d-M-y H:i',$this->getMiddleArrivalDateTimeAttribute());


            $arrival = $departure->copy()->setTimeFromTimeString($this->rest_time);

        // agar arrival time chhota hai departure se → next day
            if ($arrival->lt($departure)) {
                $arrival->addDay();
            }

            return $arrival->format('d-M-y H:i');
        }
        

        // $datetime = \Carbon\Carbon::createFromFormat('d-M-y H:i', $this->getMiddleArrivalDateTimeAttribute());
        // $duration = $this->rest_time;
        // [$hours, $minutes] = explode(':', $duration);
        // $result = $datetime
        //     ->addHours($hours)
        //     ->addMinutes($minutes);
        // return $result->format('d-M-y H:i');
    }

    public function getMiddleReturnDepartureDateTimeAttribute()
    {
        $middleDeparture = \Carbon\Carbon::createFromFormat('d-M-y H:i', $this->getMiddleReturnArrivalDateTimeAttribute())
        ->setTimeFromTimeString($this->return_rest_time)->format('d-M-y H:i');
        return $middleDeparture;

        // $datetime = \Carbon\Carbon::createFromFormat('d-M-y H:i', $this->getMiddleReturnArrivalDateTimeAttribute());
        // $duration = $this->return_rest_time;
        // [$hours, $minutes] = explode(':', $duration);
        // $result = $datetime
        //     ->addHours($hours)
        //     ->addMinutes($minutes);
        // return $result->format('d-M-y H:i');
    }

    public function getFirstDurationAttribute(){
        $start = \Carbon\Carbon::parse($this->getDepartureDateTimeAttribute());
        $end   = \Carbon\Carbon::parse($this->getMiddleArrivalDateTimeAttribute());

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
        if($this->getMiddleDepartureDateTimeAttribute() != null){
            $start = \Carbon\Carbon::createFromFormat('d-M-y H:i', $this->getMiddleDepartureDateTimeAttribute());
            $end   = \Carbon\Carbon::createFromFormat('d-M-y H:i', $this->getArrivalDateTimeAttribute());

            $diff = $start->diff($end);

            return $diff->format('%H'.'h %I'.'m');
        }
       
    }

    public function getBreakTimeAttribute(){
        $start = new DateTime($this->middle_arrival_time);
        $end   = new DateTime($this->rest_time);

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
        return (isset($departureTime[0])) ? $departureTime[0] : 0;
    }

    public function getDepartureTimeMinuteAttribute(){
        $departureTime = explode(':', $this->departure_time);
        return (isset($departureTime[1])) ? $departureTime[1] : 0;
    }

    public function getArrivalTimeHourAttribute(){
        $arrivalTime = explode(':', $this->arrival_time);
        return (isset($arrivalTime[0])) ? $arrivalTime[0] : 0;
    }

    public function getArrivalTimeMinuteAttribute(){
        $arrivalTime = explode(':', $this->arrival_time);
        return (isset($arrivalTime[1])) ? $arrivalTime[1] : 0;
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

    public function getMiddleArrivalTimeHourAttribute(){
        $middleArrivalTime = explode(':', $this->middle_arrival_time);
        return (isset($middleArrivalTime[0])) ? $middleArrivalTime[0] : null;
    }

    public function getMiddleArrivalTimeMinuteAttribute(){
        $middleArrivalTime = explode(':', $this->middle_arrival_time);
        return (isset($middleArrivalTime[1])) ? $middleArrivalTime[1] : null;
    }

    public function getMiddleDepartureTimeHourAttribute(){
        $middleDepartureTime = explode(':', $this->rest_time);
        return (isset($middleDepartureTime[0])) ? $middleDepartureTime[0] : null;
    }

    public function getMiddleDepartureTimeMinuteAttribute(){
        $middleDepartureTime = explode(':', $this->rest_time);
        return (isset($middleDepartureTime[1])) ? $middleDepartureTime[1] : null;
    }

    public function getMiddleReturnArrivalTimeHourAttribute(){
        $middleReturnArrivalTime = explode(':', $this->middle_return_arrival_time);
        return (isset($middleReturnArrivalTime[0])) ? $middleReturnArrivalTime[0] : null;
    }

    public function getMiddleReturnArrivalTimeMinuteAttribute(){
        $middleReturnArrivalTime = explode(':', $this->middle_return_arrival_time);
        return (isset($middleReturnArrivalTime[1])) ? $middleReturnArrivalTime[1] : null;
    }

    public function getMiddleReturnDepartureTimeHourAttribute(){
        $middleReturnDepartureTime = explode(':', $this->return_rest_time);
        return (isset($middleReturnDepartureTime[0])) ? $middleReturnDepartureTime[0] : null;
    }

    public function getMiddleReturnDepartureTimeMinuteAttribute(){
        $middleReturnDepartureTime = explode(':', $this->rest_time);
        return (isset($middleReturnDepartureTime[1])) ? $middleReturnDepartureTime[1] : null;
    }

}
