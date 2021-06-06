<?php
/**
 *  App Index
 */

  use MyBlog\Http\Router;
  use MyBlog\Http\Response;

  Router::init();

  Router::get('/', function(){
    return new Response(function(){
      echo 'aa';
    });
  });

  Router::run();