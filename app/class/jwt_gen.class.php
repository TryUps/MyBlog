<?php
  namespace MyB;
  use MyB\DB as DB;
  require_once __DIR__ . '/../libs/jwt/BeforeValidException.php';
  require_once __DIR__ . '/../libs/jwt/ExpiredException.php';
  require_once __DIR__ . '/../libs/jwt/SignatureInvalidException.php';
  require_once __DIR__ . '/../libs/jwt/JWT.php';
  use \FIREBASE\JWT\JWT as JWT;

  class JWT_GEN {
    private static $key;
    static function giveKey(){
      $db = DB::init();
      try{
        if($key = $db->select("preferences", ["name" => "JWT_KEY"])){
          $key = $key->value;
        }else{
          $key = "MYB_DEFAULT_KEY";
        }
        self::$key = $key;
      }catch(\Exception $e){
        die('error');
      }
    }
    static function token(Array $payload,string $key = 'MYB_RANGER_BLACK'): string
    {
      $key = self::$key;
      $alg = 'HS256';
      return JWT::encode($payload, $key, $alg);

      /*$header = [
        'typ' => 'JWT',
        'alg' => 'HS256'
      ];
      $header = json_encode($header);
      $header = base64_encode($header);
      $payload = json_encode($payload, true);
      $payload = base64_encode($payload);
      $signature = hash_hmac('sha256', "{$header}.{$payload}", $secret, true);
      $signature = base64_encode($signature);
      $token = "{$header}.{$payload}.{$signature}";*/
    }

    static function check(string $jwt){
      if($jwt){
        try {
          if($decoded = JWT::decode($jwt, self::$key, array('HS256'))){
            return $decoded;
          }else{
            return false;
          }
        }catch(\Exception $e){
          return false;
        }
      }else{
        return false;
      }
    }
  }

?>