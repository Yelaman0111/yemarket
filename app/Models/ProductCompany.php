<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCompany extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'product_id',
        'price',
        'sku',
        'min_order_count',
        'approved',
    ];

    public function product() 
    {
       return $this->belongsTo('App\Models\Product', 'product_id','id');
    }
    public function company() 
    {
       return $this->belongsTo('App\Models\Company', 'company_id','id');
    }
}
