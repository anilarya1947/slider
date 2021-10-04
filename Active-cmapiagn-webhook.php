<?php /*Template Name: ip address*/
get_header();

// https://integratepro.net/codeshare/73Wa1s4AxPOyc

// api url and key from ActiveCampaign > Settings > Developer
$api_url = 'https://leadiumconsulting.api-us1.com';
$api_key = 'd7578a01a8a42b17b56c4d4efcb70a6af040ccdbbde45412da5eca52c888e4c3523683f8';

// url to redirect if none provided
$url_default = 'https://license.leadium.com.au/thank-you/';

// message to show if no redirect url specified    
$default_message = 'Thank you';    



/***** do NOT edit below this line ****/



function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];
    
    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }
    
    return $ip;
}

// are the api_url and api_key set?
if ($api_url == '' || $api_key == '')
{
    die('Missing api url and / or api key');
}

// email
$email = trim(strip_tags($_REQUEST['email']));
$email_plus_sign = preg_replace("/\s+/", "+", $email);

// url
$url = trim(strip_tags($_REQUEST['url']));

// is redirect url valid?
if (filter_var($url, FILTER_VALIDATE_URL))
{
    $url_redirect = $url;
}
elseif (filter_var($url_default, FILTER_VALIDATE_URL))
{
    $url_redirect = $url_default;
}

// is email valid?
if (filter_var($email_plus_sign, FILTER_VALIDATE_EMAIL))
{
    $ip = getUserIP();

    // is IP address valid?
    if (filter_var($ip, FILTER_VALIDATE_IP))
    {
        $url = $api_url;
        
        $params = array(
            'api_key' => $api_key,
            'api_action' => 'contact_sync',
            'api_output' => 'serialize',
        );
        
        $post = array(
            'email' => $email_plus_sign,
            'ip4' => $ip,
        );
        
        $query = "";
        foreach( $params as $key => $value ) $query .= urlencode($key) . '=' . urlencode($value) . '&';
        $query = rtrim($query, '& ');
        
        $data = "";
        foreach( $post as $key => $value ) $data .= urlencode($key) . '=' . urlencode($value) . '&';
        $data = rtrim($data, '& ');
        
        $url = rtrim($url, '/ ');
        
        if ( !function_exists('curl_init') ) die('CURL not supported. (introduced in PHP 4.0.2)');
        
        if ( $params['api_output'] == 'json' && !function_exists('json_decode') ) {
            die('JSON not supported. (introduced in PHP 5.2.0)');
        }
        
        $api = $url . '/admin/api.php?' . $query;
        
        $request = curl_init($api);
        curl_setopt($request, CURLOPT_HEADER, 0);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($request, CURLOPT_POSTFIELDS, $data);
        //curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);
        
        $response = (string)curl_exec($request);
        
        curl_close($request);
        
        if ( !$response ) {
            die('Nothing was returned. Do you have a connection to Email Marketing server?');
        }
    }
}

// redirect or message
if ($url_redirect != "")
{
    header('Location: '.$url_redirect);
    exit();
}
else
{
    die($default_message);
}
