<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\User; 
use App\Mail\CommonEmail; 


//Create laravel errors array
if (! function_exists('errorArrayCreate')) 
{
    function errorArrayCreate($obj)
    {
        try
        {
            $obj    = $obj->toArray();
            $errors = array();
            if( is_array($obj) && !empty($obj))
            {
                foreach($obj as $k => $v)
                {
                    if( count($v) > 1 )
                    {
                        $err = '';
                        foreach ($v as $value)
                        {
                            $err.= $value.' && ';
                        }
                        trim($err,'&&');
                        $errors[$k] = $err;
                    }
                    else
                    {
                        $errors[$k] = $v[0];
                    }
                }
            }
            return $errors;
        }
        catch(\Exception $e){
            throw $e;
        }
    }
} 

if(! function_exists('testt')) 
{
    function testt($obj) {
        return $obj.'111111111';
    }

}

if(! function_exists('datetimest')) 
{
    function datetimest()
    {
        date_default_timezone_set('Asia/Calcutta');
        return $currentDate =Date('Y-m-d H:i:s');
    }
}

if (! function_exists('nextDate')) 
{
    function nextDate()
    {
        $startDate = time();
        date_default_timezone_set('Asia/Calcutta');
        return $currentDate=date('Y-m-d H:i:s', strtotime('+1 day', $startDate));
    }
}

//Common Email Send Function( Param1 => Template name, Param2 => Sender email , Param3 => Data send to template )
if (! function_exists('sendEmail')) {
    function sendEmail($view,$email,$data) {
        if (view()->exists('email_template.'.$view)) {
            $data['view'] = $view;
            return Mail::to($email)
                ->send(new CommonEmail($data));
        }else{
            return false;
        }
    }
}

/*
* This function use when store id available
*/
/*if(!function_exists('shopify_call')) 
{
    function shopify_call($store_id, $api_endpoint, $query = array(), $method = 'GET', $request_headers = array()) 
    {
        $result = DB::table('stores')->where('id', $store_id)->first();
        // Build URL
        $token  = $result->access_token;
        $url    = "https://" . $result->store_url . $api_endpoint;
        if(!is_null($query) && in_array($method, array('GET',  'DELETE')))
        { 
          $url = $url . "?" . http_build_query($query);
        }

        // Configure cURL
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, TRUE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_USERAGENT, 'My New Shopify App v.1');
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

        // Setup headers
        $request_headers[] = "";
        if(!is_null($token)) 
        { 
            $request_headers[] = "X-Shopify-Access-Token: " . $token; 
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);

        if($method != 'GET' && in_array($method, array('POST', 'PUT'))) 
        {
            if(is_array($query))
            {
                $query = http_build_query($query);
            }
            curl_setopt ($curl, CURLOPT_POSTFIELDS, $query);
        }
        
        // Send request to Shopify and capture any errors
        $response       = curl_exec($curl);
        $error_number   = curl_errno($curl);
        $error_message  = curl_error($curl);

        curl_close($curl);

        // Return an error is cURL has a problem
        if ($error_number) 
        {
            return $error_message;
        } 
        else 
        {
            // No error, return Shopify's response by parsing out the body and the headers
            $response = preg_split("/\r\n\r\n|\n\n|\r\r/", $response, 2);

            // Convert headers into an array
            $headers = array();
            $header_data = explode("\n",$response[0]);
            $headers['status'] = $header_data[0]; // Does not contain a key, have to explicitly set
            array_shift($header_data); // Remove status, we've already set it above
            foreach($header_data as $part) 
            {
                $h = explode(":", $part);
                $headers[trim($h[0])] = trim($h[1]);
            }
            return array('response' => $response[1]);
        }
    }
}*/

/*
* This function use when store id available
*/
if(!function_exists('shopify_call')) 
{
    function shopify_call($store_id, $api_endpoint, $query = array(), $method = 'GET', $request_headers = array()) 
    {
        $result = DB::table('stores')->where('id', $store_id)->first();

        // Build URL
        $token=$result->access_token;
        $url = "https://" . $result->store_url . $api_endpoint;
        if (!is_null($query) && in_array($method, array('GET',  'DELETE'))) $url = $url . "?" . http_build_query($query);

        // Configure cURL
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, TRUE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_USERAGENT, 'My New Shopify App v.1');
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

        // Setup headers
        $request_headers[] = "";
        if(!is_null($token)) $request_headers[] = "X-Shopify-Access-Token: " . $token;
        curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);

        if($method != 'GET' && in_array($method, array('POST', 'PUT'))) 
        {
            if(is_array($query)) $query = http_build_query($query);
            curl_setopt ($curl, CURLOPT_POSTFIELDS, $query);
        }
        
        // Send request to Shopify and capture any errors
        $response       = curl_exec($curl);
        $curl_info      = curl_getinfo($curl);
        $error_number   = curl_errno($curl);
        $error_message  = curl_error($curl);

        // Close cURL to be nice
        curl_close($curl);

        $request = array();

        if ($error_number) {     
           return array('status'=>400,'status_message'=> false, 'error'=>$error_message,'errno'=>$error_number, 'request'=>$request,'response'=>'' );
        }

        $header_size = $curl_info["header_size"];
        $msg_header = substr($response, 0, $header_size);
        $msg_body = substr($response, $header_size);
        $response_headers = http_client_response_headers($msg_header);

        $http_status_message = $response_headers['http_status_message'];
        $http_status_code = $response_headers['http_status_code'];
        $response = array('headers'=>$response_headers, 'body'=>$msg_body);

        if ($http_status_code >= 400)
        {      
            return array('status'=>$http_status_code,'status_message'=> $http_status_message,'error'=>'Bad request (something wrong with URL or parameters)','errno'=>'', 'request'=>$request,'response'=>$response );
        } 

        $link = ( isset( $response_headers['link'] ) ) ? $response_headers['link'] : '' ;
        preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $link, $match);
        if(isset( $match[0] ) && $match[0] != '' ) 
        {
            if(is_array($match))
            {
                foreach ( $match[0] as $val )
                {
                    //$response_headers['next_link'] = $val;
                }              
            }           
        }
        $res['response'] = $msg_body; 
        return $res;
    }
}

function http_client_response_headers($msg_header)
{
    $multiple_headers           = preg_split("/\r\n\r\n|\n\n|\r\r/", trim($msg_header));
    $last_response_header_lines = array_pop($multiple_headers);
    $response_headers           = array();

    $header_lines = preg_split("/\r\n|\n|\r/", $last_response_header_lines);
    list($response_headers['http_status_code'], $response_headers['http_status_message']) = explode(' ', trim(array_shift($header_lines)), 3);
    foreach ($header_lines as $header_line)
    {
        list($name, $value) = explode(':', $header_line, 2);
        $name = trim(strtolower($name));
        $value = trim($value);
        if (isset($response_headers[$name])) 
        {
            $response_headers[$name] = array (
                $response_headers[$name],
                $value
            );
        }
        else 
        {
            $response_headers[$name] = $value;
        }
    }
    return $response_headers;
}

/*
* This function use when shop & token avaiable
*/
if(!function_exists('shopifyStoreInfo')) 
{
    function shopifyStoreInfo($shop,$token,$api_endpoint, $query = array(), $method = 'GET', $request_headers = array()) 
    {

        // Build URL
        $url = "https://" . $shop . $api_endpoint;
        if (!is_null($query) && in_array($method, array('GET',  'DELETE')))
        { 
            $url = $url . "?" . http_build_query($query);
        }

        // Configure cURL
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, TRUE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_USERAGENT, 'My New Shopify App v.1');
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

        // Setup headers
        $request_headers[] = "";
        if (!is_null($token)) 
        {
            $request_headers[] = "X-Shopify-Access-Token: " . $token;
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);

        if ($method != 'GET' && in_array($method, array('POST', 'PUT'))) 
        {
            if (is_array($query)) $query = http_build_query($query);
            curl_setopt ($curl, CURLOPT_POSTFIELDS, $query);
        }
    
        // Send request to Shopify and capture any errors
        $response       = curl_exec($curl);
        $error_number   = curl_errno($curl);
        $error_message  = curl_error($curl);

        curl_close($curl);

        // Return an error is cURL has a problem
        if($error_number)
        {
            return $error_message;
        } 
        else
        {
            // No error, return Shopify's response by parsing out the body and the headers
            $response = preg_split("/\r\n\r\n|\n\n|\r\r/", $response, 2);

            // Convert headers into an array
            $headers = array();
            $header_data = explode("\n",$response[0]);
            $headers['status'] = $header_data[0]; // Does not contain a key, have to explicitly set
            array_shift($header_data); // Remove status, we've already set it above
            foreach($header_data as $part) 
            {
                $h = explode(":", $part);
                $headers[trim($h[0])] = trim($h[1]);
            }
            return array('response' => $response[1]);
        }
    }
}

if(!function_exists('Getdata')) 
{
    function Getdata($store_id,$api_endpoint)
    {
        $result     = DB::table('stores')->where('id', $store_id)->first();
        $token      = $result->access_token;
        $url        = "https://" . $result->store_url . $api_endpoint;

        $curl       = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
            "X-Shopify-Access-Token:".$token,
            "cache-control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err      = curl_error($curl);

        curl_close($curl);

        if($err) 
        {
            echo "cURL Error #:" . $err;
        } 
        else 
        {
            return $test=json_decode($response);
        }
    }
}

function preserveEmeddedPHP($string)
{
    $html = preg_replace('/\>\s+\</m', '><', $string);
    $html = trim(preg_replace('/[\t\n\r\s]+/', ' ', $html));
    return $html;
}