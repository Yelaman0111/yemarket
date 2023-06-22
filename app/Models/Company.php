<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Company extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'companies';

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'blocked',
        'image',
        'min_order_sum',
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
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];


    public function orders()
    {
        return $this->hasMany('App\Models\OrderPivot', 'company_id');
    }

    public function products()
    {
        return $this->hasMany('App\Models\ProductCompany', 'company_id');
    }

    // public function product()
    // {
    //     return $this->hasManyThrough(Product::class, ProductCompany::class, 'product_id','id' );
    // }
}
