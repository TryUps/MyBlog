<?php
/**
 *  App Index
 */

  use \MyBlog\Http\Request;
  use \MyBlog\Http\Router;

  Request::generateRequestInfo();

  Router::init();

  Router::sendResponse();