<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Load models
use App\Models\StoreOrderLineItem;

class StoreOrder extends Model
{
    use HasFactory;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = "store_orders";

    /**
    * Append new column for order_url.
    */
    protected $appends = ['order_url'];

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'store_id','customer_id','email','subtotal_price','total_price','presentment_currency','order_id','ai_total_price','widgets_id','ai_status','created_at','updated_at'
    ];

    /*
    * Accessor function to get created_at date formated.
    */
    public function getCreatedAtAttribute($value)
    {
        return date("m/d/Y",strtotime($value));
    }

    /*
    * Accessor function to get created_at date formated.
    */
    public function getOrderUrlAttribute()
    {
        return $this->order_url = 'https://'.auth()->user()->store_url.'/admin/orders/'.$this->order_id;
    }

    /*
    * Relation with store order line item table
    */
    public function products()
    {
        return $this->hasMany(StoreOrderLineItem::class,'store_order_id','id');
    }

     /*
    * The function use for get all order data with tables like store_order_line_items,store_product,store_product_variants
    */
    public function getStoreOrdersList($columns="*",$whereFilter=false,$offset,$startDate=false,$endDate=false)
    {
        $result = StoreOrder::with([
            'products' => function($query){
                $query->with([
                    'product_details' => function($query){
                        $query->select('product_id','title');
                    }
                ])
                ->select('store_order_id','product_id');
            }
        ])
        ->select($columns)
        ->where(function ($query) use ($whereFilter){
            if(!empty($whereFilter)){
                $query->where($whereFilter);
            }
        })
        ->where('ai_total_price', '>', 0)
        ->whereDate('created_at', '>=', $startDate)
        ->whereDate('created_at', '<=', $endDate)
        ->offset($offset)
        ->limit(10)
        ->get()
        ->all();

        return $result;
    }

    /*
    * The function use for get order data by id with tables like store_order_line_items,store_product,store_product_variants
    */
    public function getOrderById($columns="*",$whereFilter=false)
    {
        $result = StoreOrder::with([
            'products' => function($query){
                $query->with([
                    'product_details' => function($query){
                        $query->select('product_id','title');
                    },
                    'product_variants' => function($query){
                        $query->select('id','title');
                    },
                ])
                ->select('store_order_id','product_id','variant_id','quantity','line_price')
                ->where('ai_status',2);
            },
        ])
        ->select($columns)
        ->where(function ($query) use ($whereFilter){
            if(!empty($whereFilter)){
                $query->where($whereFilter);
            }
        })
        ->first();

        return $result;
    }
}
