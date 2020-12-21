<?php

namespace Myb;
use MyB\DB as DB;
use MyB\Permalink;

class Posts {

  static function create(Array $post)
  {
    $db = DB::init();
    extract($post);
    $title = nl2br($title);
    $title = filter_var($title, FILTER_SANITIZE_STRING);

    $post_term = Text::create_term($title);

    $summary_pattern = "/----summary----(<summary>.*?)----summary----/s";
    if(preg_match($summary_pattern, $content, $summary)){
      $summary = Text::limit($summary[1], 350);
      $content = preg_replace($summary_pattern, null, $content, 2);
    }else{
      $summary = Text::limit($content, 350);
    }

    $pat = array('/#(\w+)/', '/@(\w+)/');
    $rep = array('<a href="'.Permalink::base().'/tag/$1/" class="myb__tag" id="tag__$1">#$1</a>', '<a href="'.Permalink::base().'/user/$1/" class="myb__mention" id="mention__$1">@$1</a>');
    $content = preg_replace($pat, $rep, $content);


    $post = [
      "author" => 2, //User::session()->id,
      "title" => $title,
      "date" => gmdate('Y-m-d H:i:s', $date),
      "modify_date" => gmdate("Y-m-d H:i:s", $date),
      "summary" => $summary,
      "content" => $content,
      "term" => $post_term,
      "post_url" => Permalink::home() . date('Y/m/', strtotime($date)) . $post_term . ".html"
    ];

    $db->begin();
    $insertedPost = $db->insert('posts', $post);
    if(!$insertedPost){
      $db->rollback();
      return exit('Fatal db error');
    }
    if(count($tags) > 0){
      foreach($tags as $tag){
        $tagTerm = Text::create_term($tag);
        $tagged = $db->insert('post_tags', [
          "name" => $tag,
          "term" => $tagTerm,
          "post_id" => $insertedPost
        ]);
        if(!$tagged){
          $db->rollback();
          return exit('Fatal tag error');
        }
      }
    }
    $db->end();
    return true;
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