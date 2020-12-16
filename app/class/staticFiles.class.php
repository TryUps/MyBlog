<?php
  namespace MyB;

  class StaticFiles {

    public static function locateFile($folder, $file){
        $folder = realpath(__DIR__ . '/../../' . $folder);
          if ($ext = pathinfo($file, PATHINFO_EXTENSION)) {
            if (in_array($ext, ['html', 'php', 'json', 'xml', 'xhtml'])) {
              return die('error');
            }
            $file = $folder . '/' . $file;
            if (is_file($file)) {
              $type = mime_content_type($file);
              if ($type = 'text/plain') {
                switch ($ext) {
                case 'css':
                  $type = 'text/css';
                  break;
                case 'js':
                  $type = 'text/javascript';
                  break;
                default:
                  $type = 'text/plain';
                  break;
                }
              }
              if ($file = @file_get_contents($file)) {
                header("Content-Type: $type");
                return exit($file);
              } else {
                return die('error');
              }
            } else {
              return die('error');
            }
      } else {
        return die('error');
      }
    }
    public static function __callStatic($folder, $file){
      return self::locateFile($folder, $file[0]);
    }
  }