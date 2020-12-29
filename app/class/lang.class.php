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

    function customTranslate($text, ...$params){
      $pattern = "/[$][0-9]/";
      $arr = [];
      array_push($arr, ...$params);
      $text = preg_replace_callback($pattern, function($match) use($arr){
        $match = str_replace('$','', $match[0]);
        $text = isset($arr[$match-1]) ? $arr[$match-1] : null;
        return $text;
      }, $text);
      return $text;
    }

    function translate($text, ...$vars): string
    {
      $text = isset($this->lang[$text]) ? $this->lang[$text] : $text;
      if(preg_match("/[$][0-9]{1,3}/",$text, $match) && isset($match)){
        $text = $this->customTranslate($text, ...$vars);
      }else{
        $text = sprintf($text, ...$vars);
      }
      $text = htmlspecialchars_decode($text, ENT_NOQUOTES);
      $text = utf8_decode($text);
      return $text;
    }

    public static function __callStatic($method, $args){
      if(sizeof($args) > 1){
        //return self::$lang->{"$method.$args[0]"}->{"$args[1]"}; 
      }

      //return self::$lang->{"$method"}->{"$args[0]"}; 
    }
  }