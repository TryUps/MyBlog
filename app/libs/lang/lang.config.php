<?php
  use MyB\Lang as Lang;
  
  if($language = $qb->select("value")->from('preferences')->where('name', 'language')->execute()){
    $language = $language->fetch('column');
  }

  $language = isset($language) ? $language : 'en_US';

  $lang = new Lang($language);
  $_GLOBALS['lang'] = $lang;

  function __($text, ...$vars){
    global $lang;
    return $lang->translate($text, ...$vars);
  }