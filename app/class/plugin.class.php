<?php
  namespace MyB;

  class Plugin {
    static function Create($pluginId){
      define("$pluginId", true);
      return true;
    }
    static function Get($pluginId){
      return true;
    }
    static function Exists(){
      return false;
    }

  }