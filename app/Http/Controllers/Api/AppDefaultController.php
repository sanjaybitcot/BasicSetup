<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

//Load Model
use App\Models\Store;
use App\Models\StorePlan;
use App\Models\StoreProduct;
use App\Models\StoreProductImages;
use App\Models\StoreProductVariants;
use App\Models\StoreDeleteList;
use App\Models\StoreOrder;
use App\Models\StoreOrderLineItem;
use App\Models\PricePlans;

class AppDefaultController extends Controller
{
    /*
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(request $request)
    {
    }

    /*
    * This function use for get all products from store
    */
    public function getProductsFromStore(request $request)
    {
        $data = $request->all();
        if(!empty($data['store_id']))
        {
            $storeId    = $data['store_id'];
            $infoCheck  = StoreProduct::where(['store_id'=>$storeId])->first();
            $itemId     = 1;

            if($infoCheck)
            {
                $itemId = $infoCheck->product_id;
            }

            $ShopifyResponse = shopify_call($storeId, '/admin/api/2020-04/products/count.json', array(), 'GET');
            $response = json_decode($ShopifyResponse['response']);
            $countData= $response->count;
            $pageNo   = $countData/250;
            $pnoLimit = round($pageNo+0.55);
            $itemId   = $itemId;

            for($i=1; $i <= $pnoLimit; $i++)
            {
                $urg            = '/admin/api/2020-04/products.json?limit=250&since_id='.$itemId;
                $response       = Getdata($storeId,$urg);
                $productCount   = count($response->products);
                $j = 1;
                foreach ($response->products as $item)
                {
                    if($j == $productCount)
                    {
                        $itemId     = $item->id;
                    }
                    $checkProduct   = StoreProduct::where(['store_id' => $storeId,'product_id' => '$item->id'])->first();

                    if(!$checkProduct)
                    {
                        $postData  = [
                            "product_id"      => $item->id,
                            "store_id"        => $storeId,
                            "title"           => $item->title,
                            "vendor"          => $item->vendor,
                            "product_type"    => $item->product_type,
                            "handle"          => $item->handle,
                            "tags"            => $item->tags,
                            "published_scope" => $item->published_scope,
                        ];
                        $response = StoreProduct::create($postData);
                        $insertProductId = $response->id;

                        /*
                        * Add product Varients
                        */    
                        foreach ($item->variants as $items)
                        {
                            $insertDataVariants = [
                                "store_products_id" => $insertProductId,
                                "store_id"          => $storeId,
                                "variant_id"        => $items->id,
                                "product_id"        => $items->product_id,
                                "title"             => $items->title,
                                "price"             => $items->price,
                                "compare_at_price"  => $items->compare_at_price,
                                "sku"               => $items->sku,
                                "position"          => $items->position,
                                "fulfillment_service"   => $items->fulfillment_service,
                                "inventory_management"  => $items->inventory_management,
                                "inventory_quantity" => $items->inventory_quantity,
                                "option1"            => $items->option1,
                                "option2"            => $items->option2,
                                "option3"            => $items->option3,
                                "image_id"           => $items->image_id
                            ];
                            StoreProductVariants::create($insertDataVariants);
                        }     

                        /*
                        * Add product images
                        */    
                        foreach ($item->images as $itemimg)
                        {
                            $insertProductImages = [
                                "store_products_id" => $insertProductId,
                                "store_id"          => $storeId,
                                "image_id"          => $itemimg->id,
                                "product_id"        => $itemimg->product_id,
                                "src"               => $itemimg->src,
                                "alt"               => $itemimg->alt,
                                "position"          => $itemimg->position,
                            ];
                            StoreProductImages::create($insertDataVariants);
                        }
                    }
                    $j++;
                }
            }
            return response()->json(['status' =>true, 'message' =>'Data import','data' =>"got product"]);      
        }
        else
        {
            return response()->json(['status' =>true, 'message' =>'Data not found','data'=>[]]);
        }
    }

    /*
    * This function use for update product from store
    */
    public function updateProduct(request $request)
    {   
        $data = $request->all();
        if(!empty($data['store_id']))
        {
            $storeId      = $data['store_id'];
            $item         = (object)$data;
            $checkProduct = StoreProduct::where(['product_id' => $item->id,'store_id' => $storeId])->first();

            $productData   = [
                "product_id" => $item->id,
                "store_id"   => $storeId,
                "title"      => $item->title,
                "vendor"     => $item->vendor,
                "product_type" => $item->product_type,
                "handle"     => $item->handle,
                "tags"       => $item->tags,
                "published_scope" => $item->published_scope,
            ];
            if($checkProduct) 
            {
                StoreProduct::where(['product_id'=>$item->id])->update($productData);
                $storeProductsId = $checkProduct->id;
            }
            else
            {
                $responseModel   = StoreProduct::create($productData);
                $storeProductsId = $responseModel->id;
            }  
            
            /*
            * Update product images
            */  
            foreach ($item->variants as $items) 
            {    
                $items = (object)$items;

                $poductVariantData = [ 
                    "store_products_id" => $storeProductsId,
                    "store_id"          => $storeId,
                    "variant_id"        => $items->id,
                    "product_id"        => $items->product_id,
                    "title"             => $items->title,
                    "price"             => $items->price,
                    "compare_at_price"  => $items->compare_at_price,
                    "sku"               => $items->sku,
                    "position"          => $items->position,
                    "fulfillment_service" => $items->fulfillment_service,
                    "inventory_management"=> $items->inventory_management,
                    "inventory_quantity"  => $items->inventory_quantity,
                    "option1"             => $items->option1,
                    "option2"             => $items->option2,
                    "option3"             => $items->option3,
                    "image_id"            => $items->image_id,
                ];

                $checkVariant = StoreProductVariants::where(['product_id' => $item->id,'variant_id' => $items->id])->first();

                if($checkProduct) 
                {
                    StoreProductVariants::where(['variant_id'=>$items->id])->update($poductVariantData);
                }
                else
                {
                    StoreProductVariants::create($poductVariantData);
                } 
            }

            /*
            * Update product images
            */  
            foreach ($item->images as $itemimg) 
            {   
                $itemimg = (object)$itemimg;
                $post_data_image = [
                    "store_products_id" => $storeProductsId,
                    "store_id"          => $storeId,
                    "image_id"          => $itemimg->id,
                    "product_id"        => $itemimg->product_id,
                    "src"               => $itemimg->src,
                    "alt"               => $itemimg->alt,
                    "position"          => $itemimg->position,
                ];

                $checkVariant = StoreProductImages::where(['product_id' => $item->id,'image_id' => $items->id])->first();

                if($checkProduct) 
                {
                    StoreProductImages::where(['image_id'=>$items->id])->update($post_data_image);
                }
                else
                {
                    StoreProductImages::create($post_data_image);
                } 
            }
            return response()->json(['status' =>true, 'message' =>'Data import','data' =>"got product"]);      
        }
        else
        {
          return response()->json(['status' =>true, 'message' =>'Data not found','data'=>[]]);
        }
    }

    /*
    * This function use for delete shop data
    */
    public function deleteShopData(request $request)
    {
        $webhookPayload = $request->all();
        $shopDomain     = $webhookPayload['shop_domain'];
        $shopId         = $webhookPayload['shop_id'];
        if($shopId)
        {
            $shopInfo    = Store::where(['shop_id'=>$shopId])->first();
            $email       = $shopInfo->email;
            $shopOwner   = $shopInfo->shop_owner;
            $postShop    = [
                "store_id" => $shopInfo->id,
                "email"    => $shopInfo->email,
                "phone"    => $shopInfo->phone,
                "install_date" => $shopInfo->created_at,
                "country_name" => $shopInfo->country_name,
                "store_url"    => $shopInfo->store_url,
                "store_name"   => $shopInfo->store_name,
            ];
            $response = StoreDeleteList::create($postShop);
            $storeProductsId =  $response->id;

            if($storeProductsId)
            {
                $itemDelete = Store::where("shop_id",$shopId)->delete();
                if($itemDelete)
                {
                    //for customer 
                    $supportUnstallData = [
                        'name'      => $shopOwner,
                        'shop'      => $shopDomain,
                        'app_name'  => getenv('APP_NAME'),
                        'support_email'=> getenv('MAIL_FROM_ADDRESS'),
                        'email'     => $email,
                        'subject'   => "You have uninstalled our ".getenv('APP_NAME')." app",
                    ];
                    sendEmail('app-uninstall',$supportUnstallData['email'],[
                        'subject'       => $supportUnstallData['subject'],
                        'user_detail'   => ($supportUnstallData)?$supportUnstallData:array(),
                    ]);

                    // for support 
                    $mailTo    = "lalutale@bitcot.com";
                    $thankData = [
                        'name'      => "Support",
                        'shop'      => $shop_domain,
                        'email'     => $email,
                        'subject'   => getenv('APP_NAME').": app Uninstall",
                    ];
                    sendEmail('app-install-support-info',$mailTo,[
                        'subject'       => $thankData['subject'],
                        'user_detail'   => ($thankData)?$thankData:array(),
                    ]);

                    $mailTo = env('MAIL_FROM_ADDRESS');
                    sendEmail('app-install-support-info',$mailTo,[
                        'subject'       => $thankData['subject'],
                        'user_detail'   => ($thankData)?$thankData:array(),
                    ]);
            
                    return response()->json(['status' =>false, 'message' =>'successfully delete Shop all information from database','data' =>""]);
                }
                else
                {       
                    return response()->json(['status' =>false, 'message' =>'there are no more information.data already deleted','data' =>""]); 
                }
            } 
            else
            {
                $resp=array("status"=>"false","message"=>"missing requirment parameters");
            }
            return response()->json(['status' =>true, 'message' =>'shop data erasure','data' =>""]);  
        }
        else
        {
            return response()->json(['status' =>false, 'message' =>'Data not found','data'=>[]]);
        } 
    }

    public function customerDataRequest(request $request)
    {  
        $data = $request->all();
        if($data)
        {
            return response()->json(['status' =>true, 'message' =>'customer data request','data' =>""]);  
        }
        else
        {
            return response()->json(['status' =>false, 'message' =>'Data not found','data'=>[]]);
        } 
    }

    public function deleteCustomerData(request $request)
    { 
        $data = $request->all();
        if($data)
        {
            return response()->json(['status' =>true, 'message' =>'customer data erasure','data' =>""]);  
        }
        else
        {
            return response()->json(['status' =>false, 'message' =>'Data not found','data'=>[]]);
        }
    }

    /*
    * This function use for delete product from store
    */
    public function ProductDeleteFromStore(request $request)
    {   
        $data = $request->all();
        $data = (object)$data;
        if($data)
        {
            $itemDelete = StoreProduct::where("product_id",$data->id)->delete();
            if($itemDelete) 
            {
                return response()->json(['status' =>true, 'message' =>'Data import','data' =>"product delete product"]);  
            }
            else
            {
                return response()->json(['status' =>false, 'message' =>'Data not found','data'=>[]]);
            }
            return response()->json(['status' =>false, 'message' =>'Data import','data' =>"product delete product"]);  
        }
        else
        {
            return response()->json(['status' =>false, 'message' =>'Data not found','data'=>[]]);
        }
    }

    public function planActivation(request $request)
    {
        $data = $request->all();
        if(isset($data['charge_id']))
        {
            $storePricing = StorePlan::where(['recurring_application_charge_id'=>$data['charge_id']])->first();
            // for login
            $sinfo           = Store::where(['id' => $storePricing->store_id])->first();
            $encryptedShopId = Crypt::encryptString($sinfo->shop_id);
            $parameter       = "store_url=".$sinfo->store_url."&store_id=".$encryptedShopId;

            $pricingPlan     = PricePlans::where(['id' => $storePricing->plan_id])->first();
            $recurringArray  = [
                "recurring_application_charge" => [
                    "name"          => $pricingPlan->plan_title,
                    "price"         => $pricingPlan->plan_price,
                    "api_client_id" => rand(100000,99999999),
                    "status"        => "accepted",
                    "return_url"    => getenv('APP_URL').'/autologin?'.$parameter,
                    "billing_on"    => null,
                    "test"          => $pricingPlan->plan_env,
                    "activated_on"  => null,
                    "cancelled_on"  => null,
                    "trial_days"    => $pricingPlan->plan_trial,
                    "trial_ends_on" => null,
                    "decorated_return_url" => getenv('APP_URL').'/autologin?'.$parameter
                ]
            ];

            $ShopifyResponse = shopify_call($storePricing->store_id, '/admin/api/2020-04/recurring_application_charges/'.$data['charge_id'].'/activate.json', $recurringArray, 'POST');
            $res    = json_decode($ShopifyResponse['response']);
            $charge = $res->recurring_application_charge;
         
            if($charge)
            {
                $postPlanAct = [
                    'status'       => $charge->status,
                    'billing_on'   => $charge->billing_on,
                    'activated_on' => $charge->activated_on,
                    'trial_ends_on'=> $charge->trial_ends_on
                ];
                $response = StorePlan::where(['recurring_application_charge_id' => $charge->id])->update($postPlanAct);   

                if($charge->status == "active")
                {
                    $updateInfo = ["status"=>1];
                    $response   = Store::where(['id' => $storePricing->store_id])->update($updateInfo);
                }

               if($response)
               {
                    // $this->session->set_flashdata('msg_success', $messge="successfuly Activated plan.");
               }
               else
               {
                    // $this->session->set_flashdata('msg_error', $messge="something is wrong!");
               }
            }
            $parameter = "store_url=".$sinfo->store_url."&store_id=".$encryptedShopId;
            return redirect(getenv('APP_URL').'/autologin?'.$parameter);
        }
    }

    public function appActivation(request $request)
    {
        $get  = $request->all();
        $data = [];
        $data['product_list'] = array();
        $data['store_status'] = 2;
        $data['store_id']     = 0;
        if(!empty($get['shop']))
        {
            $storePricing = AppPublishTheme::where(['shop'=>$get['shop']])->first();
            if($storePricing)
            {
                $data['store_id'] = $storePricing->store_id;
            }

            if(@$storePricing->status_front == 1)
            {
                $data['store_status']=1;
            }
            else
            {
                $data['store_status']=2; 
            }
            return response()->json(['status' =>false, 'message' =>'Data import','data' =>$data]); 
        }
        else
        { 
            return response()->json(['status' =>false, 'message' =>'Data import','data' =>$data]); 
        }
    }

    /*
    * This function use for get store orders
    */
    public function storeOrder(Request $request)
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json);

        if($data)
        {
            $getStore  = Store::where(['store_url'=>$data->shop])->first();
            $store_id  = $getStore->id;
            $orderInfo = $data->orderInfo;
            $order_id  = $orderInfo->order_id;

            @$checkOrder = StoreOrder::where(['store_id' => $store_id,'order_id' => $order_id])->first();
        
            if(!@$checkOrder)
            {
                $data = [
                    'store_id'      => $store_id,
                    'customer_id'   => $orderInfo->customer_id,
                    'email'         => $orderInfo->email, 
                    'subtotal_price'=> $orderInfo->subtotal_price, 
                    'total_price'   => $orderInfo->total_price, 
                    'presentment_currency' => $orderInfo->presentment_currency, 
                    'order_id'      => $orderInfo->order_id, 
                    'ai_total_price'=> '0',
                ];
                $responseModel  = StoreOrder::create($data);
                $store_order_id = $responseModel->id; 
            
                $ai_total_price=0;
                foreach ($orderInfo->line_items as $item) 
                {
                    $widgets_page_id = 0;
                    $widgets_id      = 0;
                    $ai_status       = 1;
                    foreach ($data->ai_cart as $ai_item)
                    {
                        if($ai_item->VariantId == $item->variant_id)
                        {
                            $ai_total_price += $item->line_price;
                            $widgets_page_id = $ai_item->aiPageId;
                            $widgets_id      = $ai_item->aiWidgetTypeData;
                            $ai_status       = 2;
                        }
                    }

                    $storeOrderLineItem = [
                        'store_order_id'=> $store_order_id,
                        'line_price'    => $item->line_price,
                        'price'         => $item->price,
                        'product_id'    => $item->product_id,
                        'variant_id'    => $item->variant_id,
                        'quantity'      => $item->quantity,
                        'store_id'      => $store_id,
                        'widgets_page_id' => $widgets_page_id,
                        'widgets_id'    => $widgets_id,
                        'ai_status'     => $ai_status,
                    ];
                    StoreOrderLineItem::create($storeOrderLineItem);
                }

                $order_id       = $orderInfo->order_id;
                $checkOrderInfo = StoreOrder::where(['store_id' => $store_id,$customer_id => $orderInfo->customer_id])->first();

                if(empty($checkOrderInfo->order_id) || $checkOrderInfo->order_id == NULL || $checkOrderInfo->order_id == 0 )
                {
                    $urg = '/admin/api/2020-10/customers/'.$orderInfo->customer_id.'/orders.json?limit=1&status=any'; 
                    $response = Getdata($store_id,$urg);    
                    $order_id = $response->orders[0]->id;
                }

                $updateStoreOrderData = [
                    'order_id'       => $order_id ,
                    'ai_total_price' => $ai_total_price
                ];
                StoreOrder::where(['id'=>$store_order_id])->update($updateStoreOrderData);   
            }
            return 1;
        }
        else
        {
            return 0;
        }
    }
}
