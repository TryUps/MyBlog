<?php

namespace MyB;
use MyB\Http as Http;

class Json {
  public static function message(Array $msg = [])
  {
    if(isset($msg['status'])):
      Http::status($msg['status'], $msg['msg']);
    endif;  
    header("Content-Type: application/json; charset=UTF-8");
    $msg = json_encode($msg, true);
    return exit($msg);
  }

  public static function create(){}

  public static function update(){}

  public static function delete(){}
}
