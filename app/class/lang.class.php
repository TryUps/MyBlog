<?php
  namespace MyB;
  class lang {
    private $folder;
    private $file;
    private $lang;
    
    public function __construct($language = 'en_US', $country = null){
      $this->folder = realpath(__DIR__ . '/../../src/language/');
      $this->file = $this->folder . DIRECTORY_SEPARATOR . $language . ".json";
      if(file_exists($this->file)){
        $lang = file_get_contents($this->file);
        $lang = json_decode($lang, true);
        $this->lang = $lang['translations'];
      }
    }

    function get_langpacks(){
      if($dir = glob($this->folder . DIRECTORY_SEPARATOR . "*_*.json", GLOB_BRACE)){
        foreach($dir as $file){
          
        }
      }
    }

    function translate($text, ...$vars){
      if($vars){
        $text = isset($this->lang[$text]) ? $this->lang[$text] : $text;
        return sprintf($text, ...$vars);
      }
    }

    public static function __callStatic($method, $args){
      if(sizeof($args) > 1){
        //return self::$lang->{"$method.$args[0]"}->{"$args[1]"}; 
      }

      //return self::$lang->{"$method"}->{"$args[0]"}; 
    }
  }