<?php
  namespace MyB\DB\QueryBuilder;

  class Select {
    protected $db;
    protected $sql;
    protected $query;
    private array $fields = [];
    private array $table = [];
    private array $where = [];
    private array $arrWhere = [];
    private array $join = [];
    private array $union = [];
    private array $unionAll = [];
    private array $group = [];
    private array $order = [];
    private array $conditions = [];
    private bool $distinct = false;
    private int $limit = 10;
    private int $offset = 0;

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

    public function join(string $table, $on,?string $type = "INNER"): self
    {
      array_push($this->join, [
        "type" => strtoupper($type),
        "table" => $table,
        "on" => (array)$on
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
      $arr = array_map(function($where, $value){
        if($where['mode'] === null){
          $mode = "";
        }else{
          $mode = strtoupper($where['mode']);
        }
        return sprintf("%s %s %s '%s'", $mode,$where['column'], $where['condition'], $where['value']);
      }, $this->where, array_keys($this->where));

      $where = "WHERE ".implode(" ", $arr);
      return $where;
    }

    public function limit(): self
    {
      return $this;
    }

    public function offset(): self
    {
      return $this;
    }

    public function order(): self
    {
      return $this;
    }

    public function group(): self
    {
      return $this;
    }

    private function sql(): string
    {
      $sql = sprintf("SELECT %s FROM %s",
      join(', ', $this->fields),
      join(', ', $this->table));

      foreach($this->join as $join){
        $sql .= " $join[type] JOIN $join[table] ON " . join(" AND ", $join['on']);
      }

      if($this->where){
        $where = $this->getWhere();
        $sql .= " $where";
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
