<?php

/**
 * Myblog PHP Autoload
 * @version 1.0
 */


/** 
 * Function Autoload
 * @param class
 * type string
 * @return void
 */

function autoload(string $class): void
{
  $file = file_path($class);

  load_file($file);
}


function file_path($file): string
{
  $basepath = "app";
  $file = explode('\\', $file);

  if (defined('AppName') && $file[0] === AppName) {
    $file = array_diff($file, [AppName]);
  }

  $file = join(DIRECTORY_SEPARATOR, $file);
  $file = sprintf("%s.php", $file);

  $file = realpath(dirname(__DIR__) . DIRECTORY_SEPARATOR . $basepath . DIRECTORY_SEPARATOR . $file);

  return $file;
}

function load_file($file): void
{
  if (!file_exists($file) || !empty(file_get_contents($file))) {
    throw new Exception("Error Processing Request", 1);
    return;
  }

  require_once($file);
}

spl_autoload_register("autoload");
