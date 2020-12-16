<?php
  /**
   * MyBlog
   * Version: 1.0.0
   * 
   */
  $app = file_get_contents(__DIR__ . '/package.json');
  $app = json_decode($app, true);

  define('app', $app);
  define('version', $app['version']);

  define('APP_HOST', $_SERVER['HTTP_HOST']);
  define('PATH', realpath('./'));

  require_once dirname(__FILE__) . '/app/index.php';