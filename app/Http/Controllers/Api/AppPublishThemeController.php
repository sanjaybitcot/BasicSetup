<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

// Load models
use App\Models\Store;
use App\Models\AppPublishTheme;

class AppPublishThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id=0)
    {
        // find store is exist or not
        $storeId     = $id;
        $storesModel = Store::find($storeId);
        if(empty($storesModel))
        {
            return response()->json(['status' => false, 'message' => "Invalid store id {$storeId}."]);
        }

        $products = shopify_call($storeId, "/admin/api/2020-04/themes.json", array(), 'GET');
        $res      = json_decode($products['response']);
        $themeData = $res->themes;
        $allData  = [];
        foreach($themeData as $data)
        {
            unset(
                $data->created_at,
                $data->updated_at,
                $data->theme_store_id,
                $data->previewable,
                $data->processing,
                $data->admin_graphql_api_id
            );
            array_push($allData,$data);
        }

        // find app publish theme is exist or not
        $storeId     = $id;
        $appPublishThemeModel = AppPublishTheme::where('store_id',$storeId)->first();
        $status_front = '';
        if(empty($appPublishThemeModel))
        {
            $status_front = 0;
        }
        else
        {
            $status_front = $appPublishThemeModel->status_front;
        }

       // send api response
       if($allData)
       {
           return response()->json(['status' => true,'status_front' => $status_front,'data' => $allData]);
       }
       else
       {
           return response()->json(['status' => true, 'message' => 'Data not found','data'=>[]]);
       }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // find store is exist or not
        $storeId     = $id;
        $storesModel = Store::find($storeId);
        if(empty($storesModel))
        {
            return response()->json(['status' => false, 'message' => "Invalid store id {$storeId}."]);
        }
        
        // find app publish theme is exist or not
        $allData = AppPublishTheme::where('store_id',$storeId)->first();

       // send api response
       if($allData)
       {
           return response()->json(['status' => true,'data' => $allData]);
       }
       else
       {
           return response()->json(['status' => true, 'message' => 'Data not found','data'=>[]]);
       }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // find store is exist or not
        $storeId     = isset($request->store_id) ? $request->store_id : 0;
        $storesModel = Store::find($storeId);
        if(empty($storesModel))
        {
            return response()->json(['status' => false, 'message' => "Invalid store id {$storeId}."]);
        }

        // set validation rules
        $rules = [
            'store_id' => 'required',
            'theme_id' => 'required',
        ];
        $message   = []; 
        $validator = Validator::make($request->all(), $rules,$message);
        if ($validator->fails()) { 
            $allMessages = $validator->messages();
            $result      = errorArrayCreate($allMessages);
            return response()->json([
                'status' => false,
                'message'=> 'Please fill correct data',
                'errors' => $result
            ]);            
        }

        $products   = shopify_call($storeId, "/admin/api/2020-04/themes.json", array(), 'GET');
        $res        = json_decode($products['response']);
        $data       = $res->themes;
        $themeName  = '';
        foreach ($data as $theme)
        {
            if ($theme->id == $request->theme_id)
            {
                $themeName = $theme->name;
            }
        }

        // data process into table 
        $appPublishThemeId  = $request->theme_id;
        $updateOrCreateData = [
            'store_id'     => $request->store_id,
            'shop'         => $storesModel->store_url,
            'theme_id'     => $appPublishThemeId,
            'theme_name'   => $themeName,
        ];
        $whereFilter = [ 'store_id' => $storeId];       
        $updateOrCreateAppPublishTheme = AppPublishTheme::updateOrCreate($whereFilter,$updateOrCreateData);

        // send api response
        if($updateOrCreateAppPublishTheme)
        {
           
             /* app code put on shopify theme start */
              $store_id=$request->store_id;
              $shop=url()->current();
              $bc_theme_id=$appPublishThemeId;
              $theme_name=$themeName;



            if(isset($bc_theme_id))
            {       
                $snippets=$this->product_recomdtn_notify();
                $snippets_array = array("asset" => array("content_type" => "text/html",
                "key" => "snippets/product_recomdtn_notify.liquid",
                "theme_id"=>$bc_theme_id,
                "value"=>$snippets));

                $products=shopify_call($store_id, '/admin/themes/'.$bc_theme_id.'/assets.json', $snippets_array, 'PUT');
                /// create script tag
                $scriptTags=shopify_call($store_id, '/admin/api/2020-04/script_tags.json',array(), 'GET');
                $res=json_decode($scriptTags['response']);
                if($res->script_tags)
                {
                    foreach ($res->script_tags as $item)
                     {
                       shopify_call($store_id, '/admin/api/2020-04/script_tags/'.$item->id.'.json',array(), 'DELETE');
                      }
                }    
                
                $snippets_create_script_js=array("script_tag" => array(
                "event" => "onload",
                "src"=>"//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"));
                shopify_call($store_id, '/admin/api/2020-04/script_tags.json', $snippets_create_script_js, 'POST');

                $snippets_create_script=array("script_tag" => array(
                "event" => "onload",
               // "src"=>getenv('BASE_URL')."public/front_end/js/earning_recommand.js"));
               "src"=>"//indore.bitcotapps.com/shopify_test/earning_recommand.js"));
                $products=shopify_call($store_id, '/admin/api/2020-04/script_tags.json', $snippets_create_script, 'POST');

                $scriptTags=shopify_call($store_id, '/admin/themes/'.$bc_theme_id.'/assets.json?asset[key]=layout/theme.liquid&theme_id='.$bc_theme_id,array(), 'GET');

                $res=json_decode($scriptTags['response']);
                $themeLiquid=$res->asset->value;
                $themeLiquid=str_replace("{% include 'product_recomdtn_notify' %}","", $themeLiquid);
                $exhtml=explode("</body>", $themeLiquid);
                $appendHtml="{% include 'product_recomdtn_notify' %}";
                $finalHtml=$exhtml[0].$appendHtml."\n\r </body>".$exhtml[1];


                // main theme.liquid backup
                $themeArrayMain = array("asset" => array("content_type" => "text/html",
                "key"=> "layout/theme-ai-product-theme.liquid",
                "source_key"=> "layout/theme.liquid"
                // "theme_id"=>$bc_theme_id,
                ));    
                shopify_call($store_id, '/admin/themes/'.$bc_theme_id.'/assets.json', $themeArrayMain, 'PUT');

                // theme.liquid updated
                $theme_array = array("asset" => array("content_type" => "text/html",
                "key" => "layout/theme.liquid",
                "theme_id"=>$bc_theme_id,
                "value"=> $finalHtml));

                shopify_call($store_id, '/admin/themes/'.$bc_theme_id.'/assets.json', $theme_array, 'PUT');
            }
              /* app code put on shopify theme start */

                return response()->json(['status' => true, 'message' => 'App Publish Theme has been successfully.']);
        }
        else
        {
            return response()->json(['status' => false, 'message' => 'Problem in creating,try again.']);
        }
    }

    /*
    * Update the status front for app_publish_theme table.
    */
    public function updateThemeStatus(Request $request)
    {
        // find store is exist or not
        $storeId     = isset($request->store_id) ? $request->store_id : 0;
        $storesModel = Store::find($storeId);
        if(empty($storesModel))
        {
            return response()->json(['status' => false, 'message' => "Invalid store id {$storeId}."]);
        }

        // set validation rules
        $rules = [
            'store_id'     => 'required',
            'status_front' => 'required|integer|between:0,1',
        ];
        $message   = []; 
        $validator = Validator::make($request->all(), $rules,$message);
        if ($validator->fails()) { 
            $allMessages = $validator->messages();
            $result      = errorArrayCreate($allMessages);
            return response()->json([
                'status' => false,
                'message'=> 'Please fill correct data',
                'errors' => $result
            ]);            
        }

        // data process into table 
        $updateOrCreateData = [
            'store_id'     => $request->store_id,
            'shop'         => $storesModel->store_url,
            'status_front' => $request->status_front,
        ];
        $whereFilter = [ 'store_id' => $storeId];       
        $updateOrCreateAppPublishThemeStatus = AppPublishTheme::updateOrCreate($whereFilter,$updateOrCreateData);

        $theme_message = ($updateOrCreateAppPublishThemeStatus->status_front == 1) ? 'enable now.' : 'disable now.';

        // send api response
        if($updateOrCreateAppPublishThemeStatus)
        {
           return response()->json(['status' => true, 'message' => 'The product recommendations feature is '.$theme_message]);
        }
        else
        {
            return response()->json(['status' => false, 'message' => 'Problem in updating,try again.']);
        }
    }
    
 function product_recomdtn_notify(){
  return '{% comment %} ---product_recomdtn_notify---
  Do not edit this file.
  This snippet is auto generated and will be overwritten.
  {% endcomment %}
  <script>   
  var ai_product_id=0;  
  var _BCConfig = _BCConfig || {};
  var ai_shop=Shopify.shop;
  var ai_template="{{template}}";
  {% if product %}
  var ai_product_id="{{product.id}}";  
  {% endif %}  
  function loadjs(e){var a=document.getElementsByTagName("head")[0],t=document.createElement("script");return t.type="text/javascript",t.src=e,a.appendChild(t),t}window.jQuery||loadjs("//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js");
  </script><script src="//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>';
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
      
    }
}
