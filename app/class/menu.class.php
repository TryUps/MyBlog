<?php

  namespace MyB;

  class Menu {
    static $menu = [];

    static function create($menu){
      if(array_push(self::$menu, $menu)){
        return true;
      }
      return false;
    }

    static function use($menuName){

    }
  }