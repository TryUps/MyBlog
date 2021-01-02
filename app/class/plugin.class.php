<?php

namespace MyB;

class Plugin
{
  static function Create($pluginId, $pluginfile = "package.json")
  {
    $GLOBALS['supported_plugins'] = array();
    $pluginSet = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . '../../src/plugins/seo/' . $pluginfile);
    $pluginPack[$pluginId] = $pluginSet;
    array_push($GLOBALS['supported_plugins'], $pluginId);


    
    return true;
  }
  static function Get($pluginId)
  {
    return true;
  }
  static function Exists()
  {
    return false;
  }
}
