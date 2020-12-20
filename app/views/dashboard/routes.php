<?php
  use MyB\CustomRouter as Router;
  use MyB\Text as Text;

  Router::Route('/', function() use($user){
    $fullname = Text::surname($user->fullname);
    require __DIR__ . '/pages/home.php';
  });

  Router::Route('/articles', function() use($user){
    require __DIR__ . '/pages/Articles.php';
  });

  Router::Route('/articles/create', function() use($user){
    define("sidebar", false);
    require __DIR__ . '/pages/CreateArticle.php';
  });

  Router::Route('/category', function() use($user){
    require __DIR__ . '/pages/Category.php';
  });

  Router::Route('/preferences', function() use($user){
    require __DIR__ . '/pages/Preferences.php';
  });

?>