<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Load models
use App\Models\StoreProduct;
use App\Models\StoreProductVariants;

class StoreOrderLineItem extends Model
{
    use HasFactory;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = "store_order_line_items";

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'store_id','store_order_id','line_price','price','product_id','variant_id','quantity','widgets_page_id','widgets_id','ai_status','created_at','updated_at'
    ];

    /*
    * Relation with store order line item table
    */
    public function product_details()
    {
        return $this->hasOne(StoreProduct::class,'product_id','product_id');
    }

    /*
    * Relation with store product variants table
    */
    public function product_variants()
    {
        return $this->hasOne(StoreProductVariants::class,'id','variant_id');
    }
}
