<?php

namespace MyB;
use MyB\JWT_GEN as JWT;


class User {
    private $user;
    private static $db;

    function __construct(){
    }
    #@Array $credentials = []

    /* 
      $credentials = [
        "user" => string, // or "email"
        "pass" => string,
        "remember" => bool;
        "secure" => bool; // prefer true
      ]
    */
    static function login(Array $login = [], $credentials = []): bool 
    {
      self::$db = DB::init();

      $user = self::sanitize($login['user']);
      $pass = self::sanitizePass($login['pass']);
      if(self::validateMail($user)){
        $user = self::validateMail($user);
      }

      if($exists = self::user_exists($user)){
        if($passKey = self::$db->select("preferences", ["name" => "MYB_SECRET_KEY"])){
          $passKey = $passKey->value;
          $pass .= $passKey;
        }else{
          return json::message([
            "type" => "myb.error.reg.secrete_key",
            "msg" => "Fatal Error: Your secrete key doesn't exists.",
            "status" => 400
          ]);
        }
        if(password_verify($pass, $exists['pass'])){
          $user = $exists;

          $issued_at = time();          // 60 * 60 – 60 minutes / One Hour
          $expiration_time = $issued_at + (240 * 60);
          $issuer = $_SERVER['SERVER_NAME'];
          $token = [
            "iat" => $issued_at,
            "exp" => $expiration_time,
            "iss" => $issuer,
            'nbf'  => $issued_at - 1,
            "data" => [
              "id" => $user['id'],
              "user" => $user['user'],
              "email" => $user['email'],
              "fullname" => htmlspecialchars($user['fullname']),
              "birthdate" => $user['birthdate'],
              "status" => $user['status'],
              "rank" => $user['rank']
            ]
          ];

          if($jwt = JWT::token($token)){

            if($jwtDecoded = self::checkLogin($jwt)){
              setcookie("jwt", $jwt);
              setcookie("user_id", $jwtDecoded->data->id);
              return json::message([
                "type" => "myb_login_success",
                "msg" => "User logged with success",
                "jwt" => $jwt,
                "status" => 200
              ]);
            }
          }else{
            return json::message([
              "type" => "myb_login_falied",
              "msg" => "JWT not created",
              "status" => 400
            ]);
          }
        }else{
          return json::message([
            "type" => "myb_login_password_error",
            "msg" => "Password does not match.",
            "status" => 404
          ]);  
        }
      }else{
        return json::message([
          "type" => "myb_login_error",
          "msg" => "User not found.",
          "status" => 404
        ]);
      }


      return false;
    }

    static function user_exists($user){
      if(!empty($user)){
        $check = self::$db->query("SELECT id, user, email, pass, fullname, birthdate, status, rank FROM `users` WHERE (user = '$user' or email = '$user') LIMIT 0,1");
        $checkNum = $check->rowCount();
        if($checkNum > 0 && $checkNum < 2){
          return $check->fetch(\PDO::FETCH_ASSOC);
        }else{
          return false;
        }
      }else{
        return false;
      }
    }

    static function register(Array $userData): bool
    {
      self::$db = DB::init();
      
      $user = self::sanitize($userData['user']);

      if($email = self::validateMail($userData['email'])){
        $email = self::sanitize($email);
      }else{
        return json::message([
          "type" => "myb.error.reg.email",
          "msg" => "Not valid email.",
          "status" => 400
        ]);
      }

      $pass = self::sanitizePass($userData['pass']);
      $fullname = self::sanitize($userData['fullname']);
      $birthdate = self::sanitize($userData['birthdate']);

      try {
        $birthdate = \DateTime::createFromFormat("d/m/Y", $birthdate);
        $birthdate = $birthdate->getTimestamp();
        $birthdate = date('Y-m-d', $birthdate);
      } catch (\Exception $e) {
        return json::message([
          "type" => "myb.error.reg.date.format",
          "msg" => "Not valid birthdate format.",
          "status" => 400
        ]);
      } 

      $rank = 0;

      $verifyUser = "SELECT user FROM `users` WHERE user = '$user' LIMIT 0,1";
      $verifyUser = self::$db->query($verifyUser);
      $verifyUser = $verifyUser->rowCount();
      if($verifyUser === 0){
        $verifyEmail = "SELECT email FROM `users` WHERE email = '$email' LIMIT 0,1";
        $verifyEmail = self::$db->query($verifyEmail);
        $verifyEmail = $verifyEmail->rowCount();
        if($verifyEmail === 0){
          $passKey = self::$db->select("preferences", ["name" => "MYB_SECRET_KEY"]);
          $passKey = $passKey->value;
          $pass .= $passKey;
          if($pass = password_hash($pass, PASSWORD_ARGON2I)){
            $registered = time();
            $registered = date("Y-m-d H:i:s", $registered);

            $createAcc = <<<EOD
              INSERT INTO `users` SET
                user = :user,
                email = :email,
                pass = :pass,
                fullname = :fullname,
                birthdate = :birthdate,
                registered = :registered
            EOD;
            $query = self::$db->query($createAcc, [
              "user" => $user,
              "email" => $email,
              "pass" => $pass,
              "birthdate" => $birthdate,
              "fullname" => $fullname,
              "registered" => $registered
            ]);
            if($query){
              return json::message([
                "type" => "myb.sucess.createUser",
                "msg" => "User created with success",
                "status" => 201
              ]);
            }
          }else{
            return json::message([
              "type" => "myb.error.reg.password",
              "msg" => "Have a error in your password.",
              "status" => 400
            ]);
          }
        }else{
          return json::message([
            "type" => "myb.error.reg.existing.email",
            "msg" => "Have an existing user with this email `$email`",
            "status" => 400
          ]);
        }
      }else{
        return json::message([
          "type" => "myb.error.reg.existing.user",
          "msg" => "Have an existing user with this username `$user`",
          "status" => 400
        ]);
      }

      return false;
    }

    static private function checkLogin($jwt){
      if($jwt = JWT::check($jwt)){
        return $jwt;
      }else{
        return false;
      }
    }

    static function session(){
      if(isset($_COOKIE['jwt'])){
        $jwt = $_COOKIE['jwt'];
        if($user = self::checkLogin($jwt)){
          $user = $user->data;
          return $user;
        }else{
          return json::message([
            "type" => "user.expired.session",
            "msg" => "Your session was expired.",
            "status" => 400
          ]);
        }
      }else{
        return json::message([
          "type" => "user.expired.session",
          "msg" => "Your session was expired.",
          "status" => 400
        ]);
      }
    }

    static function sanitize(String $variable): string
    {
      $string = trim($variable);
      $string = filter_var($string, FILTER_SANITIZE_STRING);
      $string = stripcslashes($string);
      $string = strip_tags($string);
      $string = htmlentities($string, ENT_QUOTES, 'UTF-8');

      return $string;
    }

    static function sanitizePass(String $pass): string
    {
      $pass = htmlspecialchars(strip_tags($pass));
      return $pass;
    }

    private static function validateMail(String $email): string
    {
      $email = htmlspecialchars(strip_tags($email));
      $email = filter_var($email, FILTER_VALIDATE_EMAIL);
      if(checkdnsrr(array_pop(explode("@", $email)),"MX")){
        return $email;
      }else{
        return (bool)false;
      }
    }

    private function validateUser(){
        return false;
    }
}
