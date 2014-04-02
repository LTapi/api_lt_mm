<?php

  class Validation {

    function __construct(){}

    function email($email){
      if( preg_match("/^[a-zA-Z0-9_\-.]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-.]+$/", $email) ) return false;

      return true;
    }

    
  }
?>