<?php

namespace MyBlog\Middleware;

use MyBlog\Utils\Cache\File;
class Cache
{

  private function isCacheable($request): bool
  { 
    $CacheTime = 10;
    if($CacheTime <= 0){
      return false;
    }

    if($request::$method != 'GET'){
      return false;
    }

    /*
    $headers = $request::$headers;
    if(isset($headers['Cache-Control']) && $headers['Cache-Control'] == 'no-cache'){
      return false;
    }*/

    return true;
  }

  private function getHash($request): string
  {
    $url = $request::$route;
    $queryParams = $request::$queryParams;

    $url .= !empty($queryParams) ? '?' . http_build_query($queryParams) : '';
    
    if(empty(ltrim($url, '/'))){
      return 'cache-home.cache';
    }
    return 'cache-' . preg_replace('/[^0-9a-zA-Z]/','-', ltrim($url, '/')) . '.cache';
  }

  public function handle($request, $next)
  {
    if(!$this->isCacheable($request)) return $next($request);

    $hash = $this->getHash($request);

    return File::getCache($hash, 800, function() use($next, $request){
      return $next($request);
    });
  }
}
