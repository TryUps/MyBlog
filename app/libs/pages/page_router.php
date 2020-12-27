<?php
  use MyB\DB as DB;
  use MyB\View as View;
  use MyB\Blog as Blog;


  $template =$_REQUEST['template'];
  $action = $_REQUEST['action'];
  $params = $req['params'];

  switch($action){
    default:
      return new Blog([
        "db" => DB::init(),
        "template" => $_REQUEST['template'],
        "action" => $_REQUEST['action'],
        "params" => $req['params']
      ]);
    break;
  }