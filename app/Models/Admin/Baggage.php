<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baggage extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table='baggages';

   public function pnrs()
    {
        return $this->belongsToMany(Pnr::class, 'baggage_pnr', 'baggage_id', 'pnr_id');
    }
}
