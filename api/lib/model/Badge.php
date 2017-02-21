<?php

class Badge {
   var $level;
   var $categories;

   function __construct($level, $categoriesStr) {
      $this->level = $level;
      $this->categories = explode(",", $categoriesStr);
   }
}
