<?php
  /**
   * @package myblog
   * # Copyright TryUps Inc.
   *
   */

  error_reporting(E_ALL);
  if (function_exists('date_default_timezone_set') && function_exists('date_default_timezone_get')) {
      date_default_timezone_set(@date_default_timezone_get());
  }

  if(!defined('app')){
    return exit('Not defined MyBlog package file.');
  }

  require __DIR__ . '/vendor/autoload.php';

  require __DIR__ . '/core/myb.core.php';
