<?php

  namespace MyB\DB;

  class BuildQuery {

    public function __construct(\PDO $pdo)
    {
      
    }
    public function table(){

    }
    public function select($fields){
      $fieldsArray = [];
      if(is_string($fields)){
        $fieldsArray[] = $fields;
        $fields = $fieldsArray;
      }
      return $this;
    }
    public function insert(){

    }
    public function update(){

    }
    public function join(){

    }
    public function union(){
      
    }
  }