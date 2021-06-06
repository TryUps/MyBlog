<?php

namespace MyBlog\Middleware;

use \Closure;
use \Exception;

class Queue
{
  private static $map = [];

  private static $default = [];

  private $middlewares;

  private $controller;

  private $controllerArgs;

  public function __construct($controller, $controllerArgs, $middlewares)
  {
    $this->middlewares = array_merge(self::$default, $middlewares);
    $this->controller = $controller;
    $this->controllerArgs = $controllerArgs;
  }

  public static function setMap($map): void
  {
    self::$map = $map;
  }

  public static function setDefault($default): void
  {
    self::$default = $default;
  }

  public function next($request)
  {
    if (empty($this->middlewares)) return call_user_func_array($this->controller, $this->controllerArgs);

    $middleware = array_shift($this->middlewares);

    if (!isset(self::$map[$middleware])) {
      throw new Exception("Middleware error!", 500);
    }

    $queue = $this;
    $next = function ($request) use ($queue) {
      return $queue->next($request);
    };

    return (new self::$map[$middleware])->handle($request, $next);
  }
}
