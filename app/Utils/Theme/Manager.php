<?php

namespace MyBlog\Utils\Template;

class Manager {
  
  public static function setTemplate(string $name)
  {
    // ? Template: save on db and cache on file

    $path = self::getTemplatePath();

    $theme_path = $path . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . PHP_EOL;

    $theme_settings = array(
      "theme" => $name,
      "path" => $theme_path
    );

    $theme_settings = json_encode($theme_settings, JSON_UNESCAPED_SLASHES);

    return file_put_contents('theme.json', $theme_settings);

  }

  public static function getTemplate()
  {
    return '';
  }

  public static function getTemplatePath()
  {
    $templateDir = '';
    if(!file_exists($templateDir)){
      mkdir($templateDir, 0755, true);
    }
  }

  public static function getTemplateList()
  {

  }

}