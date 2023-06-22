<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderPivot extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'order_pivots';

    protected $fillable = [
        'company_id',
        'shop_id',
        'status',
    ];

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'order_id');
    }

    public function company() 
    {
       return $this->belongsTo('App\Models\Company','company_id', 'id');
    }
    public function shop() 
    {
       return $this->belongsTo('App\Models\Shop','shop_id', 'id');
    }
}
