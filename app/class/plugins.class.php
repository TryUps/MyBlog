<?php

namespace MyB;

class Plugins
{
  public function __construct()
  {
    
  }

  public function load_plugins()
  {
    $pluginsDir = (__DIR__ . DIRECTORY_SEPARATOR . "../../src/plugins/");
    if (is_dir($pluginsDir)) {
      if($plugins = glob($pluginsDir . "*/*.php")){
        foreach($plugins as $plugin){
          require_once($plugin);
        }
      }
    }
    return 'not loadable yet!';
  }

  public function init()
  {
  }
}
