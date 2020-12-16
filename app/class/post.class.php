<?php

namespace Myb;
use MyB\DB as DB;

class Posts {

  static function create(Array $post): bool 
  {
    extract($post);
    $db = DB::init();
    $posts = nl2br('olá mundo');


    

    return false;
  }

  static function publish(Array $post){

  }

  static function edit()
  {

  }

  static function delete()
  {

  }

}