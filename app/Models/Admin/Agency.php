<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AgencyStatus;
use App\Models\User;

class Agency extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => AgencyStatus::class,
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
