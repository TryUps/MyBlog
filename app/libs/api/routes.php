<?php
  use MyB\CustomRouter as Router;

  /*

  $timezone_identifiers = DateTimeZone::listIdentifiers();

foreach($timezone_identifiers as $key => $list){

echo $list . "<br/>";

}
  */
  Router::Route('(|\/)', function(){
    $now = new DateTime();  
    $apis = array(
      "users" => "/users",
      "user" => "/user/:id",
      "create_user" => "/user/create",
      "update_user" => "/user/edit/:{id}",
      "auth_user" => "/user/auth",
      "articles" => "/articles?{date,title,id,tag,category,page,limit,order,sort}",
      "article" => "/article/:{id,name}",
      "search" => "/search?q={query}",
      "today" => gmdate("Y-m-d\TH:i:s")
    );
    $apis = json_encode($apis, true);
    return exit($apis);
  });


  Router::Route('/auth/', function(){
    $data = json_decode(file_get_contents("php://input"));
    if(isset($data)){
      http_response_code(201);
    }else{
      http_response_code(401);
    }
  });