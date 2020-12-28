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
    global $qb;
    //TODO: Add query Builder;
    extract($options);
    $sql = "SELECT post.* FROM `posts` as post";

    $query = $qb->select("p.*")->from('posts', "p");
    
    $type = 0;
    if(isset($type)){
      switch($type){
        case 'private':
          $type = 0;
          break;
        case 'page':
          $type = 1;
          break;
        case 'published':
          $type = 2;
          break;
        case 'scheduled':
          $type = 3;
        case 'draft':
          $type = 4;
          break;
        case 'image':
          $type = 5;
          break;
        case 'video':
          $type = 6;
          break;
        case 'document':
          $type = 7;
          break;
        case 'note':
          $type = 8;
          break;
        case 'auto-draft':
          $type = 9;
        default:
          $type = 2; //? HIDDEN POST
      }
    }

    $query = $query->where("type", $type);

    if(isset($cat) && $cat = (array)$cat){
      if(count($cat) <= 1){
        $cat = $cat[0];
        $query = $query->join("post_cats AS pcat","p.id = pcat.post_id")->join("category AS cat", "pcat.cat_id = cat.id")->where('cat.term', $cat);
        //$sql .= " INNER JOIN `post_cats` AS cats ON (post.id = cats.post_id) INNER JOIN `category` AS cat ON (cats.cat_id = cat.id) AND (cat.name = '$cat' OR cat.term = '$cat' OR cat.id = '$cat')";
      }else{
        $child = $cat['child'];
        $cat = $cat[0];
        $query = $query->join("post_cats as pcat","p.id = pcat.post_id")->join("category as cat", "pcat.cat_id = cat.id")->join("category as child","child.group = cat.id", "left")->where('cat.term', $cat)->whereAnd('child.term', $child);
    
        //$sql .= " INNER JOIN `post_cats` AS cats ON (post.id = cats.post_id) INNER JOIN `category` AS cat ON (cats.cat_id = cat.id) AND (cat.name = '$cat' OR cat.term = '$cat' OR cat.id = '$cat') LEFT JOIN `category` AS child ON (child.group = cat.id) WHERE child.name = '$child'";
      }
    }

    if(isset($date)){
      if(is_array($date)){
        $date = implode('-', array_values($date));
      }
      //$date = new \ArrayObject( $dates );
      //$date = $date->getIterator();
      $date = strtotime($date) ? $date : str_replace('/','-', $date);
      /*$obj_date = \DateTime::createFromFormat('m-Y', $date);
      $obj_date = $obj_date->getTimestamp();*/
      
      $query->whereLike($qb->date('date', '%d-%m-%Y %H:%i:%s'), '%'.$date.'%');
    }

    if(isset($term) && !empty($term)){
      $query = $query->whereAnd('term', $term);
    }

    // test
    
    if(isset($tags) && is_array($tags)){
      $queryTag = $query->join("post_tags as tag", "p.id = tag.post_id", 'left');
      foreach($tags as $tag){
        $query->where('tag.term', '%'.$tag.'%',"like")->whereOr('tag.name', '%'.$tag.'%', 'like');
      }
      $query->group(['p.id']);
      $query = $queryTag;
    }

    if(isset($search)){
      $query =
      $query->join("post_tags as tag","p.id = tag.post_id",'left')
      ->join('post_cats as cats','p.id = cats.post_id', 'left')
      ->join('category as cat', 'cats.cat_id = cat.id', 'left')
      ->where('p.title', '%'.$search.'%','like')
      ->whereOr('tag.name', '%'.$search.'%','like')
      ->whereOr('cat.name', '%'.$search.'%','like')
      ->group(['p.id']);
    }


    /*

    if(isset($search)){
      $sql .= " LEFT JOIN `post_tags` AS tag ON (post.id = tag.post_id) LEFT JOIN `post_cats` AS cats ON (post.id = cats.post_id) LEFT JOIN `category` AS cat ON (cats.cat_id = cat.id) WHERE post.title LIKE '%$search%' OR tag.name LIKE '%$search%' OR cat.name LIKE '%$search%' GROUP BY post.id";

    }
    */

    /*
      Array $order = array(
        "column" => "",
        "sort" => "desc"
      )
    */

    /*if(isset($order) && is_array($order)){
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
    }*/

    if(isset($offset)){
      $query = $query->offset($offset);
    }
  
    if(isset($limit)){
      $query = $query->limit($limit);
    }

    $query->order([
      $qb->fields('p.pinned',1,0) => '',
      'p.date' => 'desc'
    ]);

    if($query = $query->execute()){
      return $query->fetchAll('assoc');
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