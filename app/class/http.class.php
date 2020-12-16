<?php
  namespace MyB;

  class Http {
    public static function status($code = 400, $msg = "Bad request."){
      $protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0';
      $status = sprintf("%s %d %s", $protocol, $code, $msg);
      header($status);
      if(http_response_code() === $code){
        return true;
      }else{
        return false;
      }
    }
  }