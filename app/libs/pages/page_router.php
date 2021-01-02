<?php
  use MyB\DB as DB;
  use MyB\View as View;
  use MyB\Blog as Blog;


  $template =$_REQUEST['template'];
  $action = $_REQUEST['action'];
  $params = $req['params'];

  return new Blog([
    "db" => DB::init(),
    "template" => $_REQUEST['template'],
    "action" => $_REQUEST['action'],
    "params" => $req['params']
  ]);