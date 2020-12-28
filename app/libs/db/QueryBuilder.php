<?php
  namespace MyB\DB;
  use MyB\Error as Error;
  use MyB\DB\QueryBuilder\Select as Select;
  use MyB\DB\QueryBuilder\Insert as Insert;
  use MyB\DB\QueryBuilder\Update as Update;
  use MyB\DB\QueryBuilder\Delete as Delete;

  use \PDO as PDO;
  use \PDOException as PDOException;
  
  class QueryBuilder {
    protected $db;

    function __construct(Array $configs = [])
    {
      extract($configs['connection']);
      switch($configs['client']){
        case 'mysql':
          $port = isset($port) ? $port : 3306;
          $timeout = isset($timeout) ? $timeout : 15;
          $conn = sprintf('mysql:host=%s;port=%s;dbname=%s;connect_timeout=%s', $hostname, $port, $database, $timeout);
          break;
        default:
          $conn = sprintf('sqlite:%s', $file);
          break;
      }
      try {
        if(isset($username,$password)){
          $db = new PDO($conn, $username, $password);
        }else{
          $db = new PDO($conn);
        }
        if(isset($options)){
          foreach($options as $option => $value){
            $db->setAttribute($option, $value);
          }
        }

        $this->db = $db;

      } catch (PDOException $e){
        return Error::DB($e);
      }
    }

    function select(...$fields): Select
    {
      $fields = !empty($fields) ? $fields : ['*'];
      $fields = is_array($fields[0]) ? $fields[0] : $fields;

      return new Select($fields, $this->db);
    }
    function insert(...$fields)
    {

    }
    function update(...$fields)
    {

    }
    function delete(...$fields)
    {

    }
    public function __destruct()
    {
      $this->db = null;
    }
  }