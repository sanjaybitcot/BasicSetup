<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Validator, DB;

// Load Models
use App\Models\Store;
use App\Models\Install;
use App\Models\User;
use App\Models\AppPublishTheme;
use App\Models\StorePlan;
use App\Models\PricePlans;

class AppSetupController extends Controller
{
    /**
    * App Install function.
    * This method call from patner account
    *  Url added for: App URL
    */
    public function index(Request $request)
    {
        $data = $request->all();
        if (!empty($data))
        {    
            $store = $data['shop']; 

            if(!empty($store))
            {    
                $store      =str_replace('http://', '', $store);
                $store      =str_replace('https://', '', $store);
                $store      =str_replace('/', '', $store);
                $storeCheck =explode(".", $store);
                if($storeCheck[1] != "myshopify")
                { 
                    return redirect()->to('unauthorize');   
                }

                $nonce  = rand();
                $apiKey = env('SHOPIFY_APIKEY');
                $scopes = env('SHOPIFY_SCOPES');
                $redirectUri = urlencode(env('SHOPIFY_REDIRECT_URI'));

                /*
                * Data process into table
                */
                $insertData = [
                    'store'       => $store,
                    'nonce'       => $nonce,
                    'access_token'=> "",
                ];
                $response = Install::create($insertData);
                if ($response) 
                {
                    $url = "https://{$store}/admin/oauth/authorize?client_id={$apiKey}&scope={$scopes}&redirect_uri={$redirectUri}&state={$nonce}";
                    return redirect()->away($url);
                }
                else
                {
                    $url = "https://{$store}/admin/oauth/authorize?client_id={$apiKey}&scope={$scopes}&redirect_uri={$redirectUri}&state={$nonce}";
                    return redirect()->away($url);
                }
            }
            else
            {
                return redirect('login');
            }
        } 
        else
        {
            redirect("index");
        }
    }

    /**
    * App login function.
    * This method call from patner account 
    * Url added for: Allowed redirection URL(s)
    */  
    public function login(Request $request)
    {
        $apiKey     = env('SHOPIFY_APIKEY');
        $secretKey  = env('SHOPIFY_SECRET');
        $getData    = $request->all();
        if (!isset($getData['code'], $getData['hmac'], $getData['shop'], $getData['state'], $getData['timestamp']))
        {
            exit;
        }

        $hmac   = $getData['hmac'];
        unset($getData['hmac']);

        $params = [];
        foreach ($getData as $key => $val) 
        {
            $params[] = "$key=$val";
        } 
        asort($params);
        $params = implode('&', $params);
        $calculatedHmac = hash_hmac('sha256', $params, $secretKey);

        $store = $getData['shop'];
        $nonce = $getData['state'];
        if($hmac === $calculatedHmac)
        {
            $client   = new Client();
            $response = $client->request(
                'POST', 
                "https://{$store}/admin/oauth/access_token",
                [
                    'form_params' => [
                        'client_id'     => $apiKey,
                        'client_secret' => $secretKey,
                        'code'          => $getData['code']
                    ]
                ]
            );

            $data        = json_decode($response->getBody()->getContents(), true);
            $accessToken = $data['access_token'];

            $nonce       = $getData['state'];
            $installData = Install::where(['nonce'=>$nonce,'store'=>$store])->first();
            if($installData) 
            {
                $id=$installData->id;
                if ($id > 0) 
                {
                    $updateData  = Install::find($id)->update([
                        'access_token' => $accessToken
                    ]);
                }
            }
            $storeId=$this->storeInfo($store,$accessToken);
            return $this->storePlanUpdate($storeId);

            /*$parameter = $this->freeApp($storeId);
            return redirect('/autologin?'.$parameter);*/
        }
    }

    /**
    * App free funtion
    */ 
    public function freeApp($storeId)
    {
        $sinfo          = Store::where(['id'=>$storeId])->first();
        $encryptedShopId= Crypt::encryptString($sinfo->shop_id);
        $parameter      = "store_url=".$sinfo->store_url."&store_id=".$encryptedShopId;
        return $parameter;
    }

    /*
    * This function use for display login page
    * Login using store url
    */
    public function storeLogin()
    {
        return view('login_view');
    }

    /*
    * This function use when APP load
    */
    public function storeInfo($shop,$token)
    {
        $infoCheck = Store::where(['store_url'=>$shop])->first();
        // Call API to get products from store
        $products  = shopifyStoreInfo($shop,$token, "/admin/api/2020-04/shop.json", array(), 'GET');
        $res       = json_decode($products['response']);
        if(!$res){
            echo "We are getting some error. please install again!";
        }
        $storeinfo=$res->shop;
        $postData =array(
            'store_url'    =>$shop,
            'shop_id'      =>$storeinfo->id,
            'access_token' =>$token,
            'email'        =>$storeinfo->email,
            'store_name'   =>$storeinfo->name,
            'country_name' =>$storeinfo->country_name,
            'shop_owner'   =>$storeinfo->shop_owner,
            'customer_email'=>$storeinfo->customer_email,
            'phone'        =>$storeinfo->phone,
            'iana_timezone'=>$storeinfo->iana_timezone,
            'currency'     =>$storeinfo->currency,
            'money_in_emails_format'=>$storeinfo->money_in_emails_format,
            'money_with_currency_in_emails_format'=>$storeinfo->money_with_currency_in_emails_format,
            'province'     =>$storeinfo->province,
            'address'      =>$storeinfo->address1,
            'city'         =>$storeinfo->city,
            'zip'          =>$storeinfo->zip
        );
        if($infoCheck)
        {
            $storeId = $infoCheck->id;
            Store::where(['store_url'=>$shop])->update($postData); 
        }
        else
        {
            $storeModel = Store::create($postData);
            $storeId    = $storeModel->id;

            $getUser    = Store::where(['store_url'=>$shop])->first();
            /*
            * Data process into table
            */
            $insertData = [
                'name'      => $getUser->shop_owner,
                'store_name'=> $getUser->store_name,
                'store_url' => $getUser->store_url,
                'email'     => $getUser->email,
                'password'  => Hash::make($getUser->shop_id),
                'shop_u_id' => $getUser->shop_id,
                'store_id'  => $getUser->id,
                'status'    => '1', 
            ];
            $response   = User::create($insertData);

            $this->installDefault($storeId,$shop);//Create snippets file and js  
            $this->InitializeWebhooks($storeId);   
            $this->EmailInstallApp($storeinfo->shop_owner,$storeinfo->email,$shop);         
        }
        return $storeId;
    }

    /*
    * This function use for create snippets file and js 
    */
    public function installDefault($storeId,$shop)
    {
        $products = shopify_call($storeId, "/admin/api/2020-04/themes.json", array(), 'GET');
        $res      = json_decode($products['response']);
        $themeList= $res->themes;
        $themess  = '';
        foreach($themeList AS $item) 
        {
            if($item->role == "main")
            {
                $themess=$item->id."@".$item->name;
                continue;
            }
        } 

        if(isset($themess))
        {
            $themes      = explode("@", $themess);
            $bcThemeId = $themes[0];       
            $themeName  = $themes[1];        
            $snippets    = $this->createSnippet();
            $snippetsArray = array(
                "asset" => array(
                    "content_type" => "text/html",
                    "key" => "snippets/product_recomdtn_notify.liquid",
                    "theme_id"=>$bcThemeId,
                    "value"=>$snippets
                )
            );

            $products  = shopify_call($storeId, '/admin/themes/'.$bcThemeId.'/assets.json', $snippetsArray, 'PUT');
            //create script tag
            $scriptTags=shopify_call($storeId, '/admin/api/2020-04/script_tags.json',array(), 'GET');
            $res       =json_decode($scriptTags['response']);
            if($res->script_tags)
            {
                foreach ($res->script_tags as $item) 
                {
                    shopify_call($storeId, '/admin/api/2020-04/script_tags/'.$item->id.'.json',array(), 'DELETE');
                }
            }

            $snippetsCreateScript= array(
                "script_tag" => array(
                    "event"  => "onload",
                    "src"    => env('APP_URL')."/public/front_end/js/earning_recommand.js"
                )
            );
            $products  =shopify_call($storeId, '/admin/api/2020-04/script_tags.json', $snippetsCreateScript, 'POST');

            $scriptTags=shopify_call($storeId, '/admin/themes/'.$bcThemeId.'/assets.json?asset[key]=layout/theme.liquid&theme_id='.$bcThemeId,array(), 'GET');

            $res        =json_decode($scriptTags['response']);
            $themeLiquid=$res->asset->value;
            $themeLiquid=str_replace("{% include 'product_recomdtn_notify' %}","", $themeLiquid);
            $exhtml     =explode("</body>", $themeLiquid);
            $appendHtml ="{% include 'product_recomdtn_notify' %}";
            $finalHtml  =$exhtml[0].$appendHtml."\n\r </body>".$exhtml[1];

            // main theme.liquid backup
            $themeArrayMain = array(
                "asset" => array(
                    "content_type" => "text/html",
                    "key"          => "layout/theme-ai-product-theme.liquid",
                    "source_key"=> "layout/theme.liquid"
                )
            );    
            shopify_call($storeId, '/admin/themes/'.$bcThemeId.'/assets.json', $themeArrayMain, 'PUT');

            // theme.liquid updated
            $theme_array = array(
                "asset" => array(
                    "content_type"  => "text/html",
                    "key"           => "layout/theme.liquid",
                    "theme_id"      => $bcThemeId,
                    "value"         => $finalHtml
                )
            );

            $products=shopify_call($storeId, '/admin/themes/'.$bcThemeId.'/assets.json', $theme_array, 'PUT');
            if($products)
            {
                $pricingPlan  = AppPublishTheme::where(['store_id'=>$storeId])->first();
                $postTheme    = [
                    "theme_id"      => $bcThemeId,  
                    "store_id"      => $storeId,  
                    "shop"          => $shop,  
                    "theme_name"    => $themeName, 
                    "status_front"  => 0, 
                ];

                if($pricingPlan)
                {
                    AppPublishTheme::where(['store_id'=>$storeId])->update($postTheme);          
                }
                else
                {
                    AppPublishTheme::create($postTheme);
                }
            }
        }
    }

    public function storePlanUpdate($storeId)
    {
        $storePricing = StorePlan::where(['store_id' => $storeId])->first();
        $sinfo        = Store::where(['id' => $storeId])->first();
        if(!$storePricing)
        {
            $pricingPlan     = PricePlans::where(['id' => 1])->first();
            $recurring_array = array(
                "recurring_application_charge" => array(
                    "name"       => $pricingPlan->plan_title,
                    "price"      => $pricingPlan->plan_price,
                    "return_url" => getenv('APP_URL').'/api/planActivation',
                    "test"       => $pricingPlan->plan_env,
                    "trial_days" => $pricingPlan->plan_trial
                )
            );
            $ShopifyResponse = shopify_call($storeId, '/admin/api/2020-04/recurring_application_charges.json', $recurring_array, 'POST');
            $res    = json_decode($ShopifyResponse['response']);
            $charge = $res->recurring_application_charge;

            if($charge)
            {
                $postPlan = array(
                    "plan_id"        => $pricingPlan->id,
                    "recurring_application_charge_id"=> $charge->id,
                    "api_client_id"  => $charge->api_client_id,
                    "price"          => $charge->price,
                    "status"         => $charge->status,
                    "confirmation_url" => $charge->confirmation_url,
                    "store_id"       => $storeId,
                    "billing_on"     => $charge->billing_on,
                    "trial_days"     => $charge->trial_days,
                );
                StorePlan::create($postPlan);
                return redirect($charge->confirmation_url);
            } 
            else
            {
                $this->session->set_flashdata('msg_error', $messge="Failed");
                return redirect()->away('dashboard');
            }
        }
        else
        {
            if($storePricing->status != "active")
            {
                $pricingPlan    = PricePlans::where(['id' => 1])->first();
                $recurring_array = array(
                    "recurring_application_charge" => array(
                        "name"      => $pricingPlan->plan_title,
                        "price"     => $pricingPlan->plan_price,
                        "return_url"=> getenv('APP_URL').'/api/planActivation',
                        "test"      => $pricingPlan->plan_env,
                        "trial_days"=> $pricingPlan->plan_trial
                    )
                );
                
                $ShopifyResponse  = shopify_call($storeId, '/admin/api/2020-04/recurring_application_charges.json', $recurring_array, 'POST');
                $res              = json_decode($ShopifyResponse['response']);
                $charge           = $res->recurring_application_charge;

                if($charge)
                {
                    $postPlan = array(
                        "plan_id"       => $pricingPlan->id,
                        "recurring_application_charge_id" => $charge->id,
                        "api_client_id" => $charge->api_client_id,
                        "price"         => $charge->price,
                        "status"        => $charge->status,
                        "confirmation_url" => $charge->confirmation_url,
                        "store_id"      => $storeId,
                        "billing_on"    => $charge->billing_on,
                        "trial_days"    => $charge->trial_days,
                    );
                    $storeUpdate = StorePlan::where(['store_id' => $storeId])->update($postPlan);    
                    echo $charge->confirmation_url;
                    return redirect()->away($charge->confirmation_url);
                } 
                else
                {
                    $this->session->set_flashdata('msg_error', $messge="Failed");
                    return redirect()->away('dashboard');
                }
            }
            else
            {
                $encrypted_shop_id  = Crypt::encryptString($sinfo->shop_id);
                $parameter          = "store_url=".$sinfo->store_url."&store_id=".$encrypted_shop_id;
                return redirect(getenv('APP_URL').'/autologin?'.$parameter);
            }
        }
    }

    public function createSnippet()
    {
        return '{% comment %} ---createSnippet---
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

    /*
    * This function use for Initialized webhooks
    */
    public function InitializeWebhooks($storeId)
    {
        $ShopInfo   = Store::where(['id'=>$storeId])->first();
        
        // App uninstalled webhook
        $appUninstalledWebhook=array(
            "webhook" => array(
                "topic"  => "app/uninstalled",
                "address"=> env('APP_URL').'/api/shop_data_erasure?store_id='.$storeId."&shop_id=".$ShopInfo->shop_id."&shop_domain=".$ShopInfo->store_url,
                "format" => "json",
            )
        );
        $this->createWebhook($storeId,'/admin/api/2020-04/webhooks.json',$appUninstalledWebhook,'POST'); 

        // Products create webhook
        $productsCreateWebhook=array(
            "webhook" => array(
                "topic"     => "products/create",
                "address"   => env('APP_URL').'/api/ProductCreateUpdateFromStore?store_id='.$storeId,
                "format"    =>"json",
            )
        );
        $this->createWebhook($storeId,'/admin/api/2020-04/webhooks.json',$productsCreateWebhook,'POST'); 

        // Products update webhook
        $productsUpdateWebhook=array(
            "webhook" => array(
                "topic" => "products/update",
                "address"=>env('APP_URL').'/api/ProductCreateUpdateFromStore?store_id='.$storeId,
                "format"=>"json",
            )
        );
        $this->createWebhook($storeId,'/admin/api/2020-04/webhooks.json',$productsUpdateWebhook,'POST');

        // Products delete webhook
        $productsDeleteWebhook=array(
                "webhook"=> array(
                    "topic"  => "products/delete",
                    "address"=>env('APP_URL').'/api/ProductDeleteFromStore?store_id='.$storeId,
                    "format" =>"json",
                )
        );
        $this->createWebhook($storeId,'/admin/api/2020-04/webhooks.json',$productsDeleteWebhook,'POST');
    }

    /*
    * This function use for create webhooks
    */
    public function createWebhook($storeId,$url,$webhookArr=array(),$method)
    {
        $response = shopify_call($storeId, $url, $webhookArr, $method);
        return $response;
    }

    public function EmailInstallApp($name,$email,$shop)
    {
        /// for customer 
        $supportinstallData = [
            'name'      => $name,
            'shop'      => $shop,
            'app_name'  => getenv('APP_NAME'),
            'email'     => $email,
            'subject'   => "Thank you for installing ".getenv('APP_NAME')." app",
        ];
        sendEmail('app-install',$supportinstallData['email'],[
            'subject'       => $supportinstallData['subject'],
            'user_detail'   => ($supportinstallData)?$supportinstallData:array(),
        ]);

        // for support 
        $mailTo    = "lalutale@bitcot.com";
        $thankData = [
            'name'      => "Support",
            'shop'      => $shop,
            'email'     => $email,
            'subject'   => getenv('APP_NAME').": app Install",
        ];
        sendEmail('app-install-support-info',$mailTo,[
            'subject'       => $thankData['subject'],
            'user_detail'   => ($thankData)?$thankData:array(),
        ]); 

        $mailTo="support@hubifyapps.com";
        sendEmail('app-install-support-info',$mailTo,[
            'subject'       => $thankData['subject'],
            'user_detail'   => ($thankData)?$thankData:array(),
        ]);       
  }
}
