<?php
  namespace MyB\Services\Articles;

use DateTime;
use MyB\Posts as Posts;
  use MyB\Json as json;


  class ArticleService {
    static function Create()
    {
      if(isset($_POST['post_title'], $_POST['post_tags'], $_POST['article_content'])){
        $date = gmdate(DATE_W3C);
        $tags = explode(',', $_POST['post_tags']);
        $post = array(
          "title" => $_POST['post_title'],
          "date" => $date,
          "content" => $_POST['article_content'],
          "tags" => $tags
        );
        return Posts::create($post);
      }
    }
  }
