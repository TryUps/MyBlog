<?php

  namespace MyB;
  use MyB\DB as DB;

  class Preferences {
    static function __callStatic($name, $arguments = null)
    {
      $db = DB::Init();
      $pref = $db->select("preferences", ["name" => $name]);
      return $pref->value;
    }
  }