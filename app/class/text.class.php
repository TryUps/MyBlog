<?php

namespace MyB;

class Text {
  static function surname(string $name): string
  {
    $name = explode(' ', $name);
    $name = "$name[0] " . $name[1][0];
    return $name;
  }

  static function limit(string $text,int $limit = 100): string
  {
    $text = strip_tags($text);
    $text = wordwrap($text);
    return mb_substr($text, 0, strrpos(mb_substr($text, 0, $limit, "UTF-8"), " "), 'UTF-8');
  }

  static function create_term(string $text): string
  {
    $text = preg_replace("~%[a-zA-Z]+%~", '', $text);
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    if (empty($text)) {
      return null;
    }
    return $text;
  }
}