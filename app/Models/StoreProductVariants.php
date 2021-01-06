<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreProductVariants extends Model
{
    use HasFactory;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = "store_product_variants";

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'store_products_id','store_id','variant_id','product_id','title','price','sku','position','compare_at_price','fulfillment_service','inventory_management','option1','option2','option3','image_id','created_at','updated_at'
    ];
}
