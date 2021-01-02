<?php
  use MyB\DB as DB;
  use MyB\DB\QueryBuilder;

  $db = new DB();

  $qb = new QueryBuilder([
    "client" => "mysql",
    "connection" => [
      "hostname" => "localhost",
      "username" => "root",
      "password" => "root",
      "database" => "myblog",
      "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
      ]
    ]
  ]);
  $_GLOBALS['qb'] = $qb;
 
  if($timezone = $qb->select("value")->from('preferences')->where('name', 'timezone')->execute()){
    $timezone = $timezone->fetch('column');
    if($timezone){
      date_default_timezone_set($timezone);
    }else{
      date_default_timezone_set("UTC");
    }
  }else{
    date_default_timezone_set("UTC");
  }

  require_once __DIR__ . '/generate-jwt-key.php';

  require_once __DIR__ . '/../libs/lang/lang.config.php';

  require_once __DIR__ . '/load_plugins.php';

  require_once __DIR__ . '/../libs/theme/theme.php';

  require_once __DIR__ . '/../libs/router/routes.php';