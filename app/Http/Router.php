<?php

namespace MyBlog\Http;

use \Closure;
use \Exception;
use \ReflectionFunction;

class Router extends Request
{
  protected static $routes = array();
  protected static $errors = array();
  protected static $url = 'http://localhost';

  public static function init(): void
  {
    if (!self::clean()) {
      return;
    }

    
  }

  public static function clean(): bool
  {
    self::$routes = [];

    return true;
  }

  public static function route(string $route, Closure $data, array $method = array())
  {
    return self::create($route, $data, $method);
  }

  public static function get(string $route, Closure $data)
  {
    return self::create($route, $data, 'GET');
  }

  public static function post(string $route, Closure $data)
  {
    return self::create($route, $data, 'POST');
  }

  public static function delete(string $route, Closure $data)
  {
    return self::create($route, $data, 'DELETE');
  }

  public static function patch(string $route, Closure $data)
  {
    return self::create($route, $data, 'PATCH');
  }

  private static function create(string $route, Closure $data, $method, $params = array()): bool
  {
    if (self::exists($route)) {
      throw new Exception("Unable to create route, duplicate route.", 400);
      return false;
    }

    $route = array(
      "route" => $route,
      "data" => $data,
      "method" => $method
    );

    array_push(self::$routes, $route);
    return true;
  }

  private static function exists($route)
  {
    return false;
  }

  private static function generateResponse()
  {

    if (empty(self::$routes)) {
      throw new Exception("Error Processing Request", 1);
    }

    foreach (self::$routes as $route) {
    }
  }

  public static function sendResponse()
  {
    try {
      return self::generateResponse();
    } catch (Exception $e) {
      echo $e->getMessage();
    }
  }
}
