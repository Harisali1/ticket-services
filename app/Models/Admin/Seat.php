<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pnr(){
        return $this->belongsTo(Pnr::class);
    }
}
