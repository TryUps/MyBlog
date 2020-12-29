<?php
  use MyB\CustomRouter as Router;

  Router::Route('(|\/)', function($req){
    require_once __DIR__ . '/pages/geral.php';
  });