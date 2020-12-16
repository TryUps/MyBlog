<?php

use MyB\Template as Template;

$values = array(
  "name" => "blog_template"
);

$theme = $db->select('preferences',$values);
$theme = $theme->value;

$options = [
  'template' => $theme
];

$template = Template::get($options);
$_REQUEST['template'] = $template;
