<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Enums\UserStatus;
use App\Models\Admin\Booking;
use App\Models\Admin\Payment;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Admin\PaymentUpload;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_type_id',
        'name',
        'email',
        'phone_no',
        'password',
        'status',
        'created_by',
        'show_pass',
        'logo',
        'total_amount',
        'ticketed_amount',
        'paid_amount',
        'remaining_amount',
        'on_approval_amount'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'status' => UserStatus::class,
    ];

    public function agency(){
        return $this->hasOne(User::Class);
    }

    public function getRemainingBalanceAttribute(){
        $balance = Booking::where('created_by', auth()->user()->id)
        ->where('is_approved', 0)
        ->whereIn('status', [2,3])
        ->sum('total_amount');
        return $balance;
    }

    public function payments()
    {
        return $this->hasMany(PaymentUpload::class, 'created_by');
    }

    // public function getOnApprovalAmountAttribute(){
    //     return $this->payments()->where('is_approved', 0)->sum('amount');
    // }

    // public function getTotalAmountAttribute()
    // {
    //     return $this->payments()->whereIn('status', [2,3])->sum('total_amount');
    // }

    // public function getTotalRemainingBalanceAttribute()
    // {
    //     return $this->payments()->whereIn('status', [2,3])->where('is_approved', 0)->sum('total_amount');
    // }

    // public function getPaidBalanceAttribute()
    // {
    //     return $this->payments()->where('status', 3)->where('is_approved', 1)->sum('total_amount');
    // }

    // public function getOnApprovalBalanceAttribute()
    // {
    //     return $this->payments()->where('status', 3)->where('payment_status', 3)->where('is_approved', 0)->sum('total_amount');
    // }

    // public function getRemainBalanceAttribute()
    // {
    //     return $this->payments()->where('status', 2)->where('is_approved', 0)->sum('total_amount');
    // }

    // public function getPartialBalanceAttribute()
    // {
    //     return $this->payments()->where('status', 3)->whereIn('payment_status', [2,3])->where('is_approved', 0)->sum('partial_pay_amount');
    // }

}
