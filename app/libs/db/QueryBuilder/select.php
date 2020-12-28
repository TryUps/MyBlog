<?php
  namespace MyB\DB\QueryBuilder;

  class Select {
    protected $db;
    protected $sql;
    protected $query;
    private $fields = [];
    private $table = [];
    private $where = [];
    private $arrWhere = [];
    private $join = [];
    private $union = [];
    private $unionAll = [];
    private $group = [];
    private $order = [];
    private $conditions = [];
    private $distinct = false;
    private $limit = 10;
    private $offset = 0;

    function __construct($fields, $db)
    {
      $this->db = $db;
      $this->fields = (array)$fields;
      return $this;
    }

    public function from(string $table, ?string $alias = null): self
    {
      if(!$alias){
        array_push($this->table, $table);
      }else{
        array_push($this->table, "${table} AS ${alias}");
      }
      return $this;
    }

    public function join(string $table, $on,?string $type = "INNER", array $and = []): self
    {
      array_push($this->join, [
        "type" => strtoupper($type),
        "table" => $table,
        "on" => (array)$on,
        "and" => (array)$and
      ]);
      return $this;
    }


    public function where(string $column, ?string $value, ?string $condition = "="): self
    {
      array_push($this->where, [
        "column" => $column,
        "condition" => $condition,
        "value" => $value,
        "mode" => null
      ]);
      return $this;
    }

    
    public function whereLike(string $column, ?string $value, ?string $condition = "LIKE"): self
    {
      array_push($this->where, [
        "column" => $column,
        "condition" => $condition,
        "value" => $value,
        "mode" => 'and'
      ]);
      return $this;
    }
    

    public function whereAnd(string $column, ?string $value, ?string $condition = "="): self
    {
      array_push($this->where, [
        "column" => $column,
        "condition" => $condition,
        "value" => $value,
        "mode" => "and"
      ]);
      return $this;
    }

    public function whereOr(string $column, ?string $value, ?string $condition = "="): self
    {
      array_push($this->where, [
        "column" => $column,
        "condition" => $condition,
        "value" => $value,
        "mode" => "or"
      ]);
      return $this;
    }

    public function whereIn(string $column, ?string $value, ?string $condition = "="): self
    {
      array_push($this->where, [
        "column" => $column,
        "condition" => $condition,
        "value" => $value,
        "mode" => "in"
      ]);
      return $this;
    }

    public function whereNot(string $column, ?string $value, ?string $condition = "="): self
    {
      array_push($this->where, [
        "column" => $column,
        "condition" => $condition,
        "value" => $value,
        "mode" => "not"
      ]);
      return $this;
    }

    private function getWhere(): string
    {
      $arr = array_map(function($where){
        if($where['mode'] === null){
          $mode = "";
        }else{
          $mode = strtoupper($where['mode']);
        }
        return sprintf("%s %s %s '%s'", $mode, $where['column'], $where['condition'], $where['value']);
      }, $this->where, array_keys($this->where));

      if(isset($arr[1]) && !preg_match("/(AND|OR|NOT|IN) (.*)/",$arr[1], $match)){
        $arr[1] = " AND " . $arr[1];
      }
      $where = "WHERE ".implode(" ", $arr);
      return $where;
    }

    public function limit(Int $limit = 10): self
    {
      $this->limit = $limit;
      return $this;
    }

    public function offset(Int $offset = 0): self
    {
      $this->offset = $offset;
      return $this;
    }

    public function order(Array $order = []): self
    {
      $this->order = $order;
      return $this;
    }

    public function group(Array $group = []): self
    {
      $this->group = $group;
      return $this;
    }

    private function sql(): string
    {
      $sql = sprintf("SELECT %s FROM %s",
      join(', ', $this->fields),
      join(', ', $this->table));

      foreach($this->join as $join){
        $sql .= " $join[type] JOIN $join[table] ON (" . join(" AND ", $join['on']) . ")";
        if(!empty($join['and'])){
          $and = array_map(function($key, $val){
            return "$val = '$key'";
          }, $join['and'],array_keys($join['and']));
  
          $sql .= " AND (". join(" OR ", $and) .")";
        }
      }

      if($this->where){
        $where = $this->getWhere();
        $sql .= " $where";
      }

      if($this->group){
        $group = " GROUP BY (";
        $group .= implode(', ', $this->group) . ")";
        $sql .= $group;
      }

      if($this->order){
        $orderBy = " ORDER BY ";
        $orderBy .= implode(', ', array_map(function($key, $val){
          return sprintf("%s %s",$val, strtoupper($key));
        }, $this->order, array_keys($this->order)));
        $sql .= $orderBy;
      }

      if($this->limit){
        $limit = " LIMIT " . $this->limit;
        $sql .= $limit;
      }
      
      if($this->offset){
        $offset = " OFFSET " . $this->offset;
        $sql .= $offset;
      }

      return $sql;
    }

    function __toString()
    {
      return $this->sql();
    }

    function execute(){
      $sql = $this->sql();

      $query = $this->db->prepare($sql);
      if($query->execute()){
        $this->query = $query;
        return $this;
      }
    }

    function fetch($mode = 'both'){
      $mode = $this->fetchMode($mode);
      return $this->query->fetch($mode);
    }

    function fetchAll($mode = 'both'){
      $mode = $this->fetchMode($mode);
      return $this->query->fetchAll($mode);
    }

    private function fetchMode($mode)
    {
      $mode = strtolower($mode);
      if($mode === "obj")return \PDO::FETCH_OBJ;
      if($mode === "num")return \PDO::FETCH_NUM;
      if($mode === "both")return \PDO::FETCH_BOTH;
      if($mode === "into")return \PDO::FETCH_LAZY;
      if($mode === "lazy")return \PDO::FETCH_INTO;
      if($mode === "named")return \PDO::FETCH_NAMED;
      if($mode === "assoc")return \PDO::FETCH_ASSOC;
      if($mode === "class")return \PDO::FETCH_CLASS;
      if($mode === "bound")return \PDO::FETCH_BOUND;
      if($mode === "column")return \PDO::FETCH_COLUMN;
    }

    function __destruct()
    {
      return null;
    }
  }
