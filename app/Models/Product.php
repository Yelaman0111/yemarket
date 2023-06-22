<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'description',
        'image',
        'approved',
    ];

    public function brand() 
    {
       return $this->belongsTo('App\Models\Brand','brand_id', 'id');
    }
    public function companiesProduct()
    {
        return $this->hasMany('App\Models\ProductCompany', 'product_id', 'id');
    }
    public function category() 
    {
       return $this->belongsTo('App\Models\Category','category_id', 'id');
    }
}
 