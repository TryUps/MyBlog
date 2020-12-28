<?php
  use MyB\DB as DB;
  use MyB\DBO as DBO;
  use MyB\Lang as Lang;
  use MyB\JWT_GEN as JWT;
  use MyB\DB\QueryBuilder;

  $db = new DB();

  $dbo = new DBO();

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

  $select = $qb->select('p.*')->from('posts','p');
  foreach($select as $post){
    var_dump($post);
  }

  $timezone = $db->select("preferences", ["name" => "timezone"]);
  if($timezone){
    $timezone = $timezone->value;
    date_default_timezone_set($timezone);
  }else{
    date_default_timezone_set("America/Sao_Paulo");
  }

  JWT::giveKey();

  require_once __DIR__ . '/../libs/theme/theme.php';

  require_once __DIR__ . '/../libs/router/routes.php';