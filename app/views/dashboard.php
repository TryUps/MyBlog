<?php
namespace MyB\Views;
use MyB\Error as Error;
use MyB\User as User;

class Dashboard {

  public static function Signin(){
    require __DIR__ . '/dashboard/login.php';
  }
  public static function Signup(){

  }
  public static function Router($req, $res = null){
    $route = "/".$req['params']['page'];
    if($user = User::session()){
      require_once __DIR__ . '/dashboard/index.php';
    }else{
      self::Error('Not logged user.');
    }
    
  }
  public static function Signout(){
    $_COOKIE['jwt'] = null;
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
