<?php


$values = array(
    "id" => 2,
    "name" => "blog_desc"
  );

  $select = $db->select('preferences',$values);
  echo $select->value;