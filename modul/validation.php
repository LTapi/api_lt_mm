<?php

  class Validation {

    function __construct(){}

    function email($email){

      if( preg_match("/^[a-zA-Z0-9_\-.]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-.]+$/", $email) ) return false;

      return true;
    }

    function name($name){

      if( !empty($name) && iconv_strlen($name) >= 3 ) return false;

      return true;
    }


    function adress($adress){

      if( !empty($adress) && iconv_strlen($adress) >= 5 ) return false;

      return true;
    }

    function phone($phone){
      preg_match_all("/\d/", $phone, $phoneNumArray);

      if( !empty($phone) && count($phoneNumArray[0]) >= 8 ) return false;

      return true;
    }

  }
?>