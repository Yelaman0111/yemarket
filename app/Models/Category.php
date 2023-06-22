<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes; 

    protected $fillable = [
        'parent_id',
        'title',
        'image_path',
    ];

    public function parent()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Category', 'parent_id');
    }
    public function products()
    {
        return $this->hasMany('App\Models\Product', 'category_id');
    }

    // recursive, loads all descendants
    public function childCategories()
    {
    return $this->children()->with('childCategories');
    }

    public function scopePopular(Builder $query): void
    {
        $query->where('parent_id', '!=',  '0')
        ->whereHas('products',function($q){
            $q->whereHas('companiesProduct');
        });
    }
}
