<?php

use MyB\CustomRouter as Router;
use MyB\Permalink as Link;

header("Access-Control-Allow-Origin: ".Link::base());
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
if (isset($_GET['authkey']) && $_GET['authkey'] === "0x21") {
  require_once __DIR__ . '/routes.php';
  $route = Router::Router($params);
  return $route;
} else {
  $response = array(
    "route" => Link::base('api') . $params,
    "code" => 404,
    "message" => "Invalid authkey."
  );
  $response = json_encode($response, true);
  exit($response);
}
