<?php

namespace MyB;

class Permalink {
  static function generate(){

  }
  static function home(){
    return sprintf(
      "%s://%s/",
      isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
      $_SERVER['SERVER_NAME']
    );
  }
  static function base(?string ...$links){
    $url = sprintf(
      "%s://%s",
      isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
      $_SERVER['SERVER_NAME']
    );
    if($links){
      $urls = [];
      array_push($urls, ...$links);
      $url .= DIRECTORY_SEPARATOR . implode('/', $urls);
    }
    return $url;
  }
  static function actual(){
    return sprintf("%s://%s%s", isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http', $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI']);
  }
  static function post($data){
    $date = date('Y/m', strtotime($data['date']));
    return sprintf("%s%s/%s.html",self::home(),$date,$data['term']);
  }
  static function category($cat){
    return sprintf("%scategory/%s/",self::home(),$cat['term']);
  }
  static function tag($tag){
    return sprintf("%stag/%s/",self::home(),$tag);
  }

  static function go($url = '/'){
		$baseUrl = self::base();
		$location = sprintf("Location: %s%s", $baseUrl, $url);
    header("HTTP/3.0 302 Redirecting...");
		return header($location) or die('fatal error.');
	}

  static function __callStatic($var, $args){
    $var = strtolower($var);
    switch($var){
      case 'home':
        return self::home();
        break;
      case 'base':
        return self::base();
        break;
      case 'actual':
        return self::actual();
        break;
      case 'post':
        return self::post($args);
        break;
      case 'category':
        return self::category($args);
        break;
      case 'tag':
        return self::tag($args);
        break;
      default:
        return self::home();
    }
  }
}