<?php
  use MyB\CustomRouter as Router;
  use MyB\Text as Text;

  Router::Route('/', function() use($user){
    $fullname = Text::surname($user->fullname);
    require __DIR__ . '/pages/Home/home.php';
  });

  Router::Route('/articles', function() use($user){
    require __DIR__ . '/pages/Articles/Articles.php';
  });

  Router::Route('/articles/create', function() use($user){
    if(!defined('sidebar')){
      define("sidebar", false);
    }
    require __DIR__ . '/pages/Articles/CreateArticle.php';
  });

  Router::Route('/articles/edit/:id', function() use($user){
    if(!defined('sidebar')){
      define("sidebar", false);
    }
    require __DIR__ . '/pages/Articles/EditArticle.php';
  });

  Router::Route('/comments', function() use($user){
    require __DIR__ . '/pages/Comments/Comments.php';
  });

  Router::Route('/Media', function() use($user){
    require __DIR__ . '/pages/Media/Media.php';
  });

  Router::Route('/category', function() use($user){
    require __DIR__ . '/pages/Category/Category.php';
  });

  Router::Route('/preferences', function() use($user){
    require __DIR__ . '/pages/Preferences/Preferences.php';
  });

?>