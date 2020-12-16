<?php
  namespace MyB;
  class Lang {
    private static $lang;
    public function __construct($language = 'en_US', $country = null){
      $dir = dirname(__FILE__);
      $lang = file_get_contents("$dir/../../src/language/$language.json");
      $lang = json_decode($lang);

      if(!@$lang->{"language.$language"}){
        exit("<code class='myb__error myb__fatal_error'><h1>Fatal Error</h1><p>Error in language package file: <em>`language.$language`</em> is not set</p></code>");
        return;
      }
      self::$lang = $lang->{"language.$language"};
    }

    public static function __callStatic($method, $args){
      if(sizeof($args) > 1){
        return self::$lang->{"$method.$args[0]"}->{"$args[1]"}; 
      }

      return self::$lang->{"$method"}->{"$args[0]"}; 
    }
  }