<?php

namespace Myb;
use MyB\DB as DB;

class Posts {

  static function create(Array $post): bool 
  {
    $db = DB::init();
    extract($post);
    $title = nl2br($title);
    $title = filter_var($title, FILTER_SANITIZE_STRING);

    $post_term = Text::create_term($title);

    
  
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