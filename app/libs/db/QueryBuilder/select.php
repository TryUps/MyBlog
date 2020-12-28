<?php
  namespace MyB\DB\QueryBuilder;

  class Select {
    protected $db;
    protected $sql;
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

    function __toString()
    {
      $this->sql = sprintf("SELECT %s FROM %s",
      join(', ', $this->fields),
      join(', ', $this->table));

      foreach($this->join as $join){
        $this->sql .= " $join[type] JOIN $join[table] ON " . join(" AND ", $join['on']);
      }

      if($this->where){
        $where = $this->getWhere();
        $this->sql .= " $where";
      }

      return $this->sql;
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

    function __destruct()
    {
      $sql = $this->__toString();
      $query = $this->db->prepare($sql);
      if($query->execute()){
        return $query->fetchAll(\PDO::FETCH_ASSOC);
      }
    }
  }