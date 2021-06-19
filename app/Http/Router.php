<?php

namespace MyBlog\Http;

use \Closure;
use \Exception;
use \ReflectionFunction;
use MyBlog\Middleware\Queue as MiddlewareQueue;

class Router extends Request
{
  protected static $routes = array();
  protected static $errors = array();

  public static function init(): void
  {
    if (!self::clean()) {
      return;
    }

    parent::init();
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

  public static function error(Int $code, Closure $callback)
  {
    $error = array(
      "code" => $code,
      "callback" => $callback
    );

    array_push(self::$errors, $error);
  }

  private static function create(string $route, Closure $data, $method, $middlewares = [], $params = array()): bool
  {
    if (self::exists($route, $method)) {
      throw new Exception("Unable to create route, duplicate route.", 400);
      return false;
    }

    foreach ($params as $key => $value) {

      if ($value instanceof Closure) {
        $params['controller'] = $value;
        unset($params[$key]);
        continue;
      }
    }

    $pattern = "/:[a-zA-Z]+/i";
    if (preg_match_all($pattern, $route, $matches, PREG_UNMATCHED_AS_NULL)) {
      foreach ($matches[0] as $match) {
        $expo = str_replace(':', '', $match);
        $route = str_replace($match, "(?'$expo'[^/]+)", $route);
      }
    }

    $route = array(
      "route" => str_replace('/', '\/',$route),
      "callback" => $data,
      "method" => $method,
      "middlewares" => []
    );

    array_push(self::$routes, $route);
    return true;
  }

  private static function exists($route, $method = 'GET')
  {
    return false;
  }

  private static function generateResponse()
  {

    if (empty(self::$routes)) {
      throw new Exception("Error Processing Request, no route found.", 404);
    }

    $work['route'] = false;
    $work['method'] = false;

    foreach (self::$routes as $route) {

      $realRoute = $route['route'];

      $patternRoute = '/^' . $realRoute . '$/i';

      if (preg_match_all($patternRoute, parent::$route, $params, PREG_SET_ORDER)) {

        $work['route'] = true;

        foreach ((array)$route['method'] as $allowedMethod) {

          if (strtolower(parent::$method) === strtolower($allowedMethod)) {

            if (!is_callable($route['callback'])) {
              throw new Exception("Error processing request", 500);
            }

            $work['method'] = true;

            $args = [];
            $params = $params[0];
            array_shift($params);

            Request::setParams($params);

            $reflection = new ReflectionFunction($route['callback']);
            foreach ($reflection->getParameters() as $parameter) {
              $name = $parameter->getName();
              $args[$name] = $params[$name] ?? '';
            }

            return (new MiddlewareQueue($route['callback'], $args, $route['middlewares']))->next(Request::class); 
          }
        }
      }
    }

    if (!$work['route']) {

      throw new Exception('Page not found.', 404);
    } elseif (!$work['method']) {

      throw new Exception('Invalid method', 405);
    }
  }

  public static function getError($e)
  {
    foreach (self::$errors as $error) {
      if ($error['code'] === $e->getCode()) {
        $work['error'] = true;
        return call_user_func($error['callback']);
      }
    }

    return new Response($e->getCode(), $e->getMessage());
  }

  public static function run()
  {
    try {

      return self::generateResponse();

    } catch (Exception $e) {

      return self::getError($e);
    }
  }
}
