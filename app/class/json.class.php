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

  public static function create($file, Array $content = []){

  }

  public static function update($file, Array $content = []){
    $file = file_get_contents($file);
    $file = json_decode($file, true);
  }

  public static function delete(){}
}
