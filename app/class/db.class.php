<?php

namespace MyB;
use \PDO;
use \PDOException;
use MyB\Error as Error;
use MyB\DBConfig as DBConfig;


class DB extends DBConfig {
  private $db;
  private static $instance;

  public function __construct(\PDO $db = null){
    $config = parent::settings();
    if($config['driver'] === 'sqlite'){
      $conn = sprintf('%s:%s', $config['driver'], $config['file']);
    }else{
      $conn = sprintf('%s:host=%s;port=%s;dbname=%s;connect_timeout=15', $config['driver'], $config['host'], $config['port'], $config['database']);
    }

    try {
      $pdo = null;
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
    
    $this->db = null;
    $this->db = $pdo;
  }

  public static function init(){
    if(!isset($instance)){
      $object = __CLASS__;
      self::$instance = new $object;
    }
    return self::$instance;
  }

  public function query(string $sql,Array $values = array()){
    $query = null;
    try {
      $query = $this->db->prepare($sql);
      if(isset($values) && !empty($values)){
        foreach($values as $key => &$val){
          $query->bindValue(":" . $key, $val, $this->getType($val));
        }
      }
      if($query->execute()){
        return $query;
      }
    }catch(PDOException $e){
      return Error::DB($e);
    }
  }

  public function select($table, $where = null){
    try{
      if($where === null){
        $sql = "SELECT * FROM $table";
        $sth = $this->db->prepare($sql);
      }else{
        foreach($where as $key => $val){
          $wheres[] = $key . " = :".$key;
        }
        $wheres = implode(" AND ", $wheres);
        $sql = "SELECT * FROM $table WHERE ($wheres)";
        $sth = $this->db->prepare($sql);
        foreach($where as $key => &$val){
          $sth->bindValue(":" . $key, $val, $this->getType($val));
        }
      }

      if($sth->execute()){
        $obj = $sth->fetch(PDO::FETCH_OBJ);
        return $obj;
      }
    }catch(PDOException $e){
      return Error::DB($e);
    }
  }

    public function selectAll($table, $where = null){
    try{
      if($where === null){
        $sql = "SELECT * FROM $table";
        $sth = $this->db->prepare($sql);
      }else{
        foreach($where as $key => $val){
          $wheres[] = $key . " = :".$key;
        }
        $wheres = implode(" AND ", $wheres);
        $sql = "SELECT * FROM $table WHERE ($wheres)";
        $sth = $this->db->prepare($sql);
        foreach($where as $key => &$val){
          $sth->bindValue(":" . $key, $this->filter($val), $this->getType($val));
        }
      }

      if($sth->execute()){
        $obj = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $obj;
      }
    }catch(PDOException $e){
      return Error::DB($e);
    }
  }

  public function insert($table, $values){
    try {
      return false;
    }catch(PDOException $e){
      return Error::DB($e);
    }
  }

  public function update($table, $values){

  }

  public function delete($table, $value){
    try {
      return false;
    }catch(PDOException $e){
      return Error::DB($e);
    }
  }

  public function count($table){
    return sizeof($table);
  }

  private function filter($val){
    if(is_string($val))return filter_var($val, FILTER_SANITIZE_STRING);
    if(is_int($val))return filter_var($val, FILTER_SANITIZE_NUMBER_INT);
    if(is_bool($val))return $val;
  }

  private function getType($val){
    if(is_string($val))return PDO::PARAM_STR;
    if(is_int($val))return PDO::PARAM_INT;
    if(is_bool($val))return PDO::PARAM_BOOL;
  }

  public function __destruct(){
    unset($this->db);
    $obj = __CLASS__;
    unset($obj);
  }
}
