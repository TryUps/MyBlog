<?php

namespace MyBlog\Middleware;

use \Closure;

class Queue
{
  public function __construct(Closure $callback, $args, $middlewares)
  {
  }

  public function next($next)
  {
  }
}
