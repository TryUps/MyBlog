<?php
  namespace MyB;
  use MyB\DBConfig as DBConfig;
  use \PDO;
  use \PDOException;

  class DBO extends DbConfig {
    protected $pdo;
    function __construct(){
      $config = parent::settings();
      if($config['driver'] === 'sqlite'){
        $conn = sprintf('%s:%s', $config['driver'], $config['file']);
      }else{
        $conn = sprintf('%s:host=%s;port=%s;dbname=%s;connect_timeout=15', $config['driver'], $config['host'], $config['port'], $config['database']);
      }

      try {
        $pdo = new PDO($conn, $config['username'], $config['password']);
      } catch (PDOException $e){
        return Error::DB($e);
      }
      $options = $config['options'];

      foreach($options as $option => $value){
        try{
          $pdo->setAttribute($option, $value);
        }catch(PDOException $e){
          return Error::DB($e);
        }
      }

      return $pdo;
    }
  }