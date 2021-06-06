<?php

namespace MyBlog\Utils\Cache;

use \Closure;

class File
{

  private static function getFilePath($hash)
  {
    $cacheDir = dirname(__DIR__) . '/../../cache';
    
    if(!file_exists($cacheDir)){
      mkdir($cacheDir, 0755, true);
    }

    return $cacheDir . '/' . $hash;
  }

  private static function storageCache($hash, $content)
  {
    $serialized = serialize($content);
    
    $cacheFile = self::getFilePath($hash);

    return file_put_contents($cacheFile, $serialized);
  }

  private static function getContentCache($hash, $expiration)
  {
    $cacheFile = self::getFilePath($hash);

    if(!file_exists($cacheFile)){
      return false;
    }

    $createTime = filectime($cacheFile);
    $diffTime = time() - $createTime;
    if($diffTime > $expiration){
      return false;
    }

    $serialized = file_get_contents($cacheFile);
    return unserialize($serialized);
  }

  /** 
   * Função para obtenção do cache
   * @param string $hash
   * @param integer $expiration
   * @param Closure $data
   * @return mixed
   */
  public static function getCache(string $hash, int $expiration, Closure $data)
  {

    if($content = self::getContentCache($hash, $expiration)){
      return $content;
    }

    $content = $data();

    self::storageCache($hash, $content);

    return $content;
  }
}
