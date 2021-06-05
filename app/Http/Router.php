<?php

namespace MyBlog\Http;

use \Closure;
use \Exception;
use \ReflectionFunction;

class Router
{
  protected static $routes = array();
  protected static $errors = array();
  protected static $url = 'http://localhost';

  public function init(): void
  {
    if (!self::clean()) {
      return;
    }

    //Request::init();
  }

  public function clean(): bool
  {
    self::$routes = [];

    return true;
  }

  public static function route()
  {
  }

  public static function get()
  {
  }

  public static function post()
  {
  }

  public static function delete()
  {
  }

  public static function patch()
  {
  }

  private static function create(string $route, Closure $data, $method, $params = array())
  {
  }

  private static function sendResponse()
  {

    foreach (self::$routes as $route){
      
    }

  }
}
