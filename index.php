<?php
  /**
   * MyBlog: The Preview
   * Version: 1.0.0-dev.1
   */

  $app = file_get_contents(__DIR__ . "/package.json");
  $app = json_decode($app, true);

  define('App', $app);
  define('AppName', $app['appName']);

  require_once __DIR__ . '/config.php';

  require_once __DIR__ . '/vendor/autoload.php';

  require_once __DIR__ . '/app/index.php';
