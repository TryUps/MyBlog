<?php

namespace Myb;
use MyB\DB as DB;
/*
  

  $posts_by_cat = Query::posts([
    "cat" => "Sem Categoria", // cat_name: Sem Categoria, cat_id: 1, cat_permalink: sem-categoria
    "limit" => 10 // Number (int)
  ]); // retorna um array

  $posts_by_tags = Query::posts([
    "tag" => ["filme","serie","livro"],
    "order" => "id",
    "limit" => 150
  ]); // retorna um array

  $posts_by_ids = Query::posts([
    "id" => [1,10.25],
    "limit" => 3
  ]);

  
*/

class Query {
  
  static function posts(array $options = []): array
  {
    $db = DB::init();
    extract($options);
    $sql = "SELECT post.* FROM `posts` as post";

    if(isset($cat) && $cat = (array)$cat){
      if(count($cat) <= 1){
        $cat = $cat[0];
        $sql .= " INNER JOIN `post_cats` AS cats ON (post.id = cats.post_id) INNER JOIN `category` AS cat ON (cats.cat_id = cat.id) AND (cat.name = '$cat' OR cat.term = '$cat' OR cat.id = '$cat')";
      }else{
        $child = $cat['child'];
        $cat = $cat[0];
        $sql .= " INNER JOIN `post_cats` AS cats ON (post.id = cats.post_id) INNER JOIN `category` AS cat ON (cats.cat_id = cat.id) AND (cat.name = '$cat' OR cat.term = '$cat' OR cat.id = '$cat') LEFT JOIN `category` AS child ON (child.group = cat.id) WHERE child.name = '$child'";
      }
    }

    if(isset($tag) && is_array($tag)){
      $sql .= "";
    }

    if(isset($date)){
      $sql .= " WHERE DATE_FORMAT( `date`, '%Y-%m' ) = '$date'";
    }

    if(isset($term)){
      $sql .= " and `term` = '$term'";
    }

    if(isset($search)){
      $sql .= " LEFT JOIN `post_tags` AS tag ON (post.id = tag.post_id) LEFT JOIN `post_cats` AS cats ON (post.id = cats.post_id) LEFT JOIN `category` AS cat ON (cats.cat_id = cat.id) WHERE post.title LIKE '%$search%' OR tag.name LIKE '%$search%' OR cat.name LIKE '%$search%' GROUP BY post.id";

    }

    /*
      Array $order = array(
        "column" => "",
        "sort" => "desc"
      )
    */

    if(isset($order) && is_array($order)){
      $column = $order['column'];
      if(is_array($column)){
        $column = implode(",", $column);
      }
      $sort = $order['sort'];
      $sql .= "ORDER BY $column ";
      switch($sort){
        case 'asc':
          
          break;
        default:
          $sql .= " DESC";
      }
    }

    if(isset($advancedOrder)){
      $sql .= " ORDER BY $advancedOrder";
    }

    if(isset($limit)){
      $sql .= " LIMIT $limit";
    }

    
    if($sql && $query = $db->query($sql)){
      return($query->fetchAll(\PDO::FETCH_ASSOC));
    }
    return [];
  }
  static function category($options = []): array
  {
    $db = DB::init();
    $sql = "SELECT * FROM `category`";
    if($sql && $query = $db->query($sql)){
      return($query->fetchAll(\PDO::FETCH_ASSOC));
    }
    return [];
  }
  static function tags($options = []){
    $db = DB::init();
    $sql = "SELECT count(*), name FROM `post_tags` GROUP BY `name` LIMIT 10";
    if($sql && $query = $db->query($sql)){
      return($query->fetchAll(\PDO::FETCH_ASSOC));
    }
    return [];
  }
  static function search(){

  }
  static function preferences(){

  }

}