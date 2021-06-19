<?php

namespace MyBlog\Utils\Template;

class Composer {
  public $actualTheme;

  public static function layout(): void
  {
    /*
      <Layout import='header' />
    */
  }

  public static function component(): void
  {
    /*
      <ComponentName />

      <ComponentName>
      
      <>
      </>

      </ComponentName>
    */

  }

  // 

  public static function loop(): void
  {
    /*
      <Loop array as {string}>
    */
  }

  public static function if():void
  {
    /*
      <If {block} @!<><==> {block2}>
    */
  }

  public static function __callStatic($name, $arguments)
  {
    
  }

  public static function open(): string
  {
    return '';
  }

  public static function render(string $file, ?array $vars = [])
  {

  }

}
