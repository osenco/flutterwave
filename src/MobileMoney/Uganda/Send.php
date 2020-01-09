<?php

function getKey($seckey){
  $hashedkey = md5($seckey);
  $hashedkeylast12 = substr($hashedkey, -12);

  $seckeyadjusted = str_replace("FLWSECK-", "", $seckey);
  $seckeyadjustedfirst12 = substr($seckeyadjusted, 0, 12);

  $encryptionkey = $seckeyadjustedfirst12.$hashedkeylast12;
  return $encryptionkey;

}

function encrypt3Des($data, $key)
 {
  $encData = openssl_encrypt($data, 'DES-EDE3', $key, OPENSSL_RAW_DATA);
        return base64_encode($encData);
 }


function encryptMpesa(){ // set up a function to test card payment.
    
    error_reporting(E_ALL);
    ini_set('display_errors',1);
    
    $data = array('PBFPubKey' => 'FLWPUBK-7adb6177bd71dd43c2efa3f1229e3b7f-X',
    'currency' => 'KES',
    'country' => 'KE',
    'payment_type' => 'mpesa',
    'amount' => '30',
    'phonenumber' => '054709929300',
    'firstname' => 'Paul',
    'lastname' => 'Kagaru',
    'narration' => 'mpesa/12394484',
    'email' => 'tester@flutter.co',
    'IP' => '103.238.105.185',
    'txRef' => 'MXX-ASC-4578',
    'is_mpesa' => 1,
    'device_fingerprint' => '69e6b7f0sb72037aa8428b70fbe03986c');
    
    $SecKey = 'FLWSECK-e6db11d1f8a6208de8cb2f94e293450e-X';
    
    $key = getKey($SecKey); 
    
    $dataReq = json_encode($data);
    
    $post_enc = encrypt3Des( $dataReq, $key );

    var_dump($post_enc);
    
    
}

encryptMpesa();
function send(){

$postdata = array(
     'PBFPubKey' => 'FLWPUBK-7adb6177bd71dd43c2efa3f1229e3b7f-X',
     'client' => $post_enc,
     'alg' => '3DES-24');
    
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, "https://api.ravepay.co/flwv3-pug/getpaidx/api/charge");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata)); //Post Fields
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 200);
    curl_setopt($ch, CURLOPT_TIMEOUT, 200);
    
    
    $headers = array('Content-Type: application/json');
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $request = curl_exec($ch);
    
    if ($request) {
        $result = json_decode($request, true);
        echo "<pre>";
        print_r($result);
    }else{
        if(curl_error($ch))
        {
            echo 'error:' . curl_error($ch);
        }
    }
    
    curl_close($ch);
}

payviampesa();


}
