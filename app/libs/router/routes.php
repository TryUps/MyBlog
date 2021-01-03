<?php
  use MyB\Router as Router;
  use MyB\User as User;
  use MyB\Template as Template;
  use MyB\View as View;

  Router::get('/install', function(){
    //require_once(dirname(__FILE__) . '/../../core/install/index.php');
  });

  Router::get("/(?'dash'signin|signup|signout)", function($req, $res){
    $params = $req['params'];
    $link = explode('/',$params[0]);
    $page = $link[0];
    $page = ucfirst($page);
    $page = "MyB\Views\Dashboard::{$page}";
    return call_user_func_array($page, array($req,$res));
  });

  Router::post('/signin', "MyB\Services\Auth\AuthService::Login");

  Router::post('/signup', "MyB\Services\Auth\AuthService::Register");

  Router::route("/api(?<api>.*?)", function($req, $res){
    $params = $req['params']['api'];
    require_once __DIR__ . '/../api/index.php';
    return;
  }, ['GET','POST','PUT','DELETE','PATCH','OPTIONS','HEAD']);

  Router::get("/(?'dash'(dash|dash\/|dash/(?<action>assets)/(?<file>(.*?)))|dash/(?'page'.*))", function($req, $res){
    $params = $req['params'];
    $link = explode('/',$params[0]);
    $page = $link[0];
    if(in_array("assets", $params)){
      $page = 'assets';
    }
    $page = ucfirst($page);
    $page = "MyB\Views\Dashboard::{$page}";
    return call_user_func_array($page, array($req,$res));
  });

  if(User::session()){
    // secure routes.
    Router::post('/dash/preferences', "MyB\Services\Preferences::Save");
    Router::post('/dash/articles/create', "MyB\Services\Articles\ArticleService::Create");
  }


  Router::get('/go/:code', function($req, $res){
    $link = $req['params']['code'];
    header("Location: ./");
    exit;
  });
