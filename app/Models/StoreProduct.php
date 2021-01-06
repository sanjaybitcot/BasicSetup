<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Load models
use App\Models\StoreProductImages;
use App\Models\StoreProductVariants;

class StoreProduct extends Model
{
    use HasFactory;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = "store_products";

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'store_id','product_id','title','vendor','product_type','handle','tags','published_scope','created_at','updated_at'
    ];

    /*
    * Relation with store product images table
    */
    public function store_product_images()
    {
        return $this->hasOne(StoreProductImages::class,'store_products_id','id');
    }
    /*
    * Relation with store product variants table
    */
    public function store_product_variants()
    {
        return $this->hasOne(StoreProductVariants::class,'store_products_id','id');
    }

    /*
    * The function use for get product dropdown list
    */
    public function getProductDropdownList($columns="*",$whereNotInFilter=false,$search='',$offset=0,$whereFilter)
    {   
        $result = StoreProduct::with([
            'store_product_images'  => function ($query){
                $query->select('store_products_id','alt','src');
            },
        ])
        ->select($columns)
        ->where(function ($query) use ($search,$whereNotInFilter,$whereFilter){
            if($search != ''){
                $query->orWhere('title', 'LIKE', '%'.$search.'%');
            }
            if(!empty($whereFilter)){
                $query->where($whereFilter);
            }
            if(!empty($whereNotInFilter)){
                $query->whereNotIn('id',$whereNotInFilter);
            }
        })
        ->offset($offset)
        ->limit(10)
        ->get()
        ->all();
        return $result;
    }
}
