<?php

namespace MyBlog\Http;
class Request
{

  public static $url = 'http://localhost';

  public static $route;

  public static $method;

  public static $params = array();

  public static $queryParams = array();

  public static $postVars = array();

  public static $headers = array();

  public static function init()
  {
    self::getUrl();
    self::getActualRoute();
    self::getMethod();
    self::getQueryParams();
    self::getPostVars();
    self::getRequestHeaders();

    return true;
  }

  private static function getUrl(): void
  {
    $http = filter_input(INPUT_SERVER, 'HTTPS', FILTER_SANITIZE_STRING);
    $http = isset($http) && $http != 'off' ? 'https' : 'http';
    $host = filter_input(INPUT_SERVER, 'HTTP_HOST', FILTER_SANITIZE_URL);
    $reqt = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL);
    $url = sprintf("%s://%s%s", $http, $host, $reqt);
    $url = trim($url, '');
    $url = urldecode($url);

    self::$url = $url;
  }

  private static function getActualRoute(): void
  {
    $url = filter_input(INPUT_SERVER, 'SCRIPT_NAME', FILTER_SANITIZE_URL);
    $url = rtrim(dirname($url), '/');
    $url = trim(str_replace($url, '', filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL)), '');
    $url = urldecode($url);
    $url = strtok($url, '?');

    self::$route = $url;
  }

  private static function getMethod(): void
  {
    $method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);
    
    if ($method == 'HEAD') {
        ob_start();
        $method = 'GET';
    }elseif ($method == 'POST') {

        $headers = self::$headers;
        if (isset($headers['X-HTTP-Method-Override']) && in_array($headers['X-HTTP-Method-Override'], array('PUT', 'DELETE', 'PATCH'))) {
            $method = $headers['X-HTTP-Method-Override'];
        }

    }

    self::$method = $method;
  }

  public static function setParams($params): void
  {
    $params = array_map(function($value){
      return filter_var($value, FILTER_SANITIZE_STRING);
    }, $params);
    
    self::$params = $params;
  }

  private static function getQueryParams(): void
  {

    $queryParams = array_map(function($value){
      return filter_var($value, FILTER_SANITIZE_STRING);
    }, $_GET);

    self::$queryParams = $queryParams;
  }

  private static function getPostVars(): void
  {
    $postVars = array_map(function($value){
      return filter_var($value, FILTER_SANITIZE_STRING);
    }, $_POST);
    
    self::$postVars = $postVars;
  }

  private static function getRequestHeaders(): void
  {
      $headers = array();

      if (function_exists('getallheaders')) {
          $headers = getallheaders();

          if ($headers !== false) {
              self::$headers = $headers;
          }
      }

      foreach ($_SERVER as $name => $value) {
          if ((substr($name, 0, 5) == 'HTTP_') || ($name == 'CONTENT_TYPE') || ($name == 'CONTENT_LENGTH')) {
              $headers[str_replace(array(' ', 'Http'), array('-', 'HTTP'), ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
          }
      }

      self::$headers = $headers;
  }

  public static function generateRequestInfo()
  {


  }

  public static function debug()
  {
    $procedures = array(
      "url" => "",
    );
    var_dump($procedures);
  }
}