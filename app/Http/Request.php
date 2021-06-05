<?php

namespace MyBlog\Http;
class Request
{

  public static $url = 'http://localhost';

  public static $route;

  public static $method;

  public static $queryParams;

  public static $postVars;

  public static $headers;

  public static function init()
  {

  }

  private static function getUrl(): void
  {

  }

  private static function getActualRoute(): void
  {

  }

  private static function getMethod(): void
  {

  }

  public static function setParams(): void
  {

  }

  private static function getParams(): void
  {

  }

  private static function getQueryParams(): void
  {
    $queryParams = array_map(function($key, $value){
      return filter_var($value, FILTER_SANITIZE_STRING);
    }, $_GET);

    self::$queryParams = $queryParams;
  }

  private static function getPostVars(): void
  {
    $postVars = array_map(function($key, $value){
      return filter_var($value, FILTER_SANITIZE_STRING);
    }, $_POST);
    
    self::$postVars = $postVars;
  }

  public static function generateRequestInfo()
  {


  }
}