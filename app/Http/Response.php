<?php

namespace MyBlog\Http;

use \Closure;

class Response
{


  private $httpCode = 200;

  private $headers = [];

  private $contentType = 'text/html';

  private $content;

  public function __construct($http_code, $responseContent, ...$http_vars)
  {

    $this->httpCode = isset($http_code) && is_int($http_code) ? $http_code : $this->httpCode;

    $this->contentType = isset($http_vars[0]) ? $http_vars[0] : $this->contentType;

    $this->content = $responseContent;
  }

  private static function addHeaders()
  {
  }

  private static function sendHeaders()
  {
  }

  public function sendResponse()
  {

    $httpCode = $this->httpCode;

    switch ($httpCode) {
      case 201:
        $httpText = "Created!";
        break;
      case 301:
        $httpText = "Moved Permanently!";
        break;
      case 301:
        $httpText = "Found!";
        break;
      case 400:
        $httpText = "Bad Request!";
        break;
      case 404:
        $httpText = "Not Found!";
        break;
      case 405:
        $httpText = "Method Not Allowed";
        break;
      case 500:
        $httpText = "Internal Server Error!";
        break;
      default:
        $httpText = "Ok!";
    }

    header("HTTP/1.1 $httpCode $httpText", true, $httpCode);

    if (is_callable($this->content)) {

      call_user_func($this->content);
    } else {

      if (!ob_start("ob_gzhandler")) ob_start();
      echo $this->MinifyResponse($this->content);
      $minified = ob_get_contents();
      ob_end_clean();

      echo $minified;
    }
  }

  private function MinifyResponse($buffer)
  {

    $search = array(
      '/(\n|^)(\x20+|\t)/',
      '/(\n|^)\/\/(.*?)(\n|$)/',
      '/\n/',
      '/\<\!--.*?-->/',
      '/(\x20+|\t)/', # Delete multispace (Without \n)
      '/\>\s+\</', # strip whitespaces between tags
      '/(\"|\')\s+\>/', # strip whitespaces between quotation ("') and end tags
      '/=\s+(\"|\')/', # strip whitespaces between = "'
      '/(?=<!--)([\s\S]*?)-->/'
    );

    $replace = array(
      "\n",
      "\n",
      " ",
      "",
      " ",
      "><",
      "$1>",
      "=$1",
      ""
    );

    $code = preg_replace($search, $replace, $buffer);
    $code = trim($code);

    return trim($code);
  }
}
