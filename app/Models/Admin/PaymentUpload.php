<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PaymentUpload extends Model
{
    use HasFactory;

    protected $guarded =[];

    public function user(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
