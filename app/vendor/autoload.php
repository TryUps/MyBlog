<?php
  function autoload($class){
    $class = strtolower($class);
    $class = explode('\\', $class);
    $size = sizeof($class);
    switch($size){
      case $size >= 3:

        $class = array_slice($class, 1);
        $ext = array_pop($class).".php";
        $class = implode('/', $class);
        $dir = "/../$class";
      break;
      default:
        $class = end($class);
        $dir = "/../class/";
        $ext = $class.spl_autoload_extensions();
      break;
    }
    $dir = realpath(dirname(__FILE__).$dir);
    $file = $dir.DIRECTORY_SEPARATOR.$ext;
    if(file_exists($file)){
      require_once($file);
      return;
    }
    return false;
  }

  spl_autoload_extensions('.class.php');
  spl_autoload_register("autoload");
?>