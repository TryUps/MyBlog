<?php
  namespace MyB\DB;
  use MyB\DB\QueryBuilder\Select as Select;
  use MyB\DB\QueryBuilder\Insert as Insert;
  use MyB\DB\QueryBuilder\Update as Update;
  use MyB\DB\QueryBuilder\Delete as Delete;

  use \PDO as PDO;
  use \PDOException as PDOException;
  
  class QueryBuilder {
    protected $pdo = null;

    function __construct(PDO $pdo = null)
    {
      $this->pdo = $pdo;
    }

    function select($fields)
    {
      $select = new Select($fields);
      return $select;
    }
  }