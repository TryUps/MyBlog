<?php
  namespace MyB\Services\Articles;
  use MyB\Json as json;


  class ArticleService {
    static function Create()
    {
      return json::message([
        "code" => 404,
        "msg" => "not found!"
      ]);
    }
  }