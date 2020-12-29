<?php

  namespace MyB;

  class CustomRouter {
    private static $routes = array();

    static function Route(String $route = '/',$callback, $method = 'GET'){
      return self::create($route, $callback, $method);
    }

    private static function create(String $route, \Closure $callback, $method){
      $route = [
        "route" => $route,
        "callback" => $callback,
        "method" => $method
      ];
      return array_push(self::$routes, $route);
    }

    static function Router($url){
      foreach(self::$routes as $route){
        if(preg_match_all("@^$route[route]$@", $url, $params, PREG_UNMATCHED_AS_NULL)){
          array_shift($params);
          $req = [
            "params" => $params
          ];
          if(is_callable($route['callback'])){
            return call_user_func_array($route['callback'], array($req,null));
          }
        }
      }
    }

    static function Clear(){
      return self::$routes = [];
    }
  }