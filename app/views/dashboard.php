<?php
namespace MyB\Views;
use MyB\Error as Error;
use MyB\User as User;
use MyB\Router as Router;
use MyB\Permalink as Link;

class Dashboard {

  public static function Signin(){
    if($user = User::session()){
      return Link::go('/dash/');
    }else{
      require_once __DIR__ . '/dashboard/login.php';
    }
  }
  public static function Signup(){
    if($user = User::session()){
      return Link::go('/dash/');
    }else{
      require_once __DIR__ . '/dashboard/register.php';
    }
  }
  public static function Router($req, $res = null){
    $route = "/".$req['params']['page'];
    if($user = User::session()){
      require_once __DIR__ . '/dashboard/index.php';
    }else{
      return Link::go('/signin');
    }
    
  }
  public static function Signout(){
    if($user = User::session()){
      require_once __DIR__ . '/dashboard/logout.php';
    }else{
      return Link::go('/signin');
    }
  }
  public static function Assets($req, $res){
    return \MyB\StaticFiles::{'./app/views/dashboard/'}('./assets/'.$req["params"]['file']);
  }
  public static function Error($pageError){
    $err = "<em>Fatal error on `$pageError`</em>";
    return exit($err);
    // Error::get(5012)
  }

  public static function __callStatic($page, $params){
    $page = strtolower($page);
    if($page === 'dash'){
      return self::Router($params[0], $params[1]);
    }elseif($page === 'assets'){
      return self::Assets($params[0], $params[1]);
    }
    return self::Error($page);
  }

}
