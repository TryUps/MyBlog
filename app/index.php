<?php
/**
 *  App Index
 */

  use MyBlog\Http\Router;
  use MyBlog\Http\Response;

  Router::init();

  Router::get('/', function(){
    return new Response(200, 'aaaa');
  });

  Router::error(404, function(){
    return new Response(404, 'Error not found in this webpage.');
  });

  Router::run()->sendResponse();