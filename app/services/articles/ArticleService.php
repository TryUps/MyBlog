<?php
  namespace MyB\Services\Articles;
  use MyB\Posts as Posts;
  use MyB\Json as json;


  class ArticleService {
    static function Create()
    {
      if(isset($_POST['post_title'], $_POST['post_tags'], $_POST['post_content'])){
        $tags = explode(',', $_POST['post_tags']);
        $post = array(
          "title" => $_POST['post_title'],
          "date" => time(),
          "content" => $_POST['post_content'],
          "tags" => $tags
        );
        if($post = Posts::create($post)){
          header('location: ./');
        }else{
          echo 'error';
        }
      }
    }
    static function Edit()
    {

    }
  }
