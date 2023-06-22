<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order  extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'orders';

    protected $fillable = [
        'order_id',
        'product_id',
        'count',
        'price',
        'status',
    ];

    public function order() 
    {
       return $this->belongsTo('App\Models\OrderPivot','order_id', 'id');
    }
    public function productCompany() 
    {
       return $this->belongsTo('App\Models\ProductCompany','product_id', 'id');
    }

}
