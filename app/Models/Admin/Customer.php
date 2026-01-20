<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function booking(){
        return $this->belongsTo(Booking::class);
    }

    public function getFullNameAttribute(){
        return trim($this->name.' '.$this->surname);
    }
}
