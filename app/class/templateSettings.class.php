<?php
namespace MyB;

use MyB\Permalink as Link;

class templateSettings {

  
  public function blogSettings(){
    $this->var('version', app['version']);
    $this->var('versionName', app['versionName']);
  }
}