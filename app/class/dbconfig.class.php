<?php

namespace MyB;

class DBConfig {
  private $settings;
  protected static function settings(){
    $config = require(dirname(__FILE__) . '/../config/db.config.php');
    $settings['driver'] = $config['driver'];

    if($settings['driver'] !== 'sqlite'){
      $settings['host'] = $config['host'];
      $settings['port'] = !isset($config['port']) ? 3306 : $config['port'];
      $settings['database'] = $config['database'];
      $settings['username'] = $config['username'];
      $settings['password'] = $config['password'];
      $settings['options'] = $config['options'];
    }elseif($settings['driver'] === 'sqlite'){
      $settings['file'] = $config['file'];
    }
    return $settings;
  }
}
