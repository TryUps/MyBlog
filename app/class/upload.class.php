<?php
  namespace MyB;

  class Upload {
    static function Thumb(Array $file){

    }

    static function Image(Array $file, $path = app['path'] . "/images/"){
      $type = $file['type'];
      $allowed = ["image/jpeg","image/png","image/gif","image/svg+xml","image/webp"];
      $taget_file = $path . basename($_FILES["fileToUpload"]["name"]);
      if(in_array($type, $allowed)){
        if(move_uploaded_file($file['tmp_name'], $taget_file)){
          return true;
        }else{

        }
      }else{
        return Json::message([
          "code" => 400,
          "msg" => "Fatal error, file type incorrect"
        ]);
      }
    }

    static function Video(Array $file, $path = './'){

    }
  }