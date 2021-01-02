<?php
  namespace MyB;

  class CustomLinks {
    private static function generate($url){

      /*
        * %pagename% -> (?'postname'[-a-z0-9])
        * %postname% -> (?'pagename'[-a-zA-Z0-9])
        * %category% -> (?'category'[-a-z])
        * %id% -> (?'id'[0-9])
        * %year% -> (?'year'[0-9]{4})
        * %month% -> (?'month'[0-9]{2})
        * %day% -> (?'day'[0-9]{2})
        * %tag% -> (?'tag'[-a-z])

        ? formatted -> https://myblog.test/%MainCategory%/%PostName%/
          ! https://myblog.test/articles/ola-mundo=como=estao/

      */

    }
  }