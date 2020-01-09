<?php

namespace Osen\Flutterwave

class Encrypt
{
  public static $key;
  
  function __construct($seckey = null){
    $hashedkey = md5($seckey);
    $hashedkeylast12 = substr($hashedkey, -12);

    $seckeyadjusted = str_replace("FLWSECK-", "", $seckey);
    $seckeyadjustedfirst12 = substr($seckeyadjusted, 0, 12);

    self::$key = $seckeyadjustedfirst12.$hashedkeylast12;
  }



function data($data)
 {
  $encData = openssl_encrypt($data, 'DES-EDE3', self::$key, OPENSSL_RAW_DATA);
        return base64_encode($encData);
 }

}
