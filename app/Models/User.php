<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }
    public function leave()
    {
        return $this->hasMany(Leave::class);
    }
    public function order_item()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function permission()
    {
        return $this->hasOne(UserPermission::class);
    }
    public function order()
    {
        return $this->hasMany(Order::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function payslip()
    {
        return $this->hasMany(Payslip::class);
    }
}
