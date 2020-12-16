<?php

namespace MyB;

class Error {

  static function Handler(\Exception $error = null){
    http_response_code(400);
    
  }

  public function msg($eCode){
    return die("<div>Error: <pre>$eCode</pre></div>");
  }

  static function template($code){
    $blogtitle = 'MyBlog';
    $template = <<<HTML
      <!DOCTYPE html>
      <html lang="en">
      <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Fatal Error: $code – $blogtitle</title>
      </head>
      <body>
        
      </body>
      </html>
    HTML;
  }

  public static function get(Int $code): string
  {
    http_response_code($code);
    return die("<div><h3>Error:</h3><pre>$code</pre></div>");
  }

  public static function DB($e = null){
    http_response_code(500);
    $code = $e->getCode();
    $msg  = $e->getMessage();
    $args = $e->getTraceAsString();
    $line = $e->getLine();
    $file = $e->getFile();
    $error = sprintf('<div class="myb__dberror"><h3>DB Error: %s</h3><p>Message: %s</p><p>Configuration: %s</p><p>Line: %s</p><p>File: %s</p></div>', $code, $msg, $args, $line, $file);
    return die($error);
  }

}
