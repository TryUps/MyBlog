<?php
  use MyB\DB as DB;
  use MyB\Lang as Lang;
  use MyB\JWT_GEN as JWT;
  use MyB\DB\QueryBuilder;

  $db = new DB();

  $query = new QueryBuilder();


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