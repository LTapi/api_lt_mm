<?php
  require_once('validation.php');

  class Get_leadtrade extends Validation {
    public $lttracking, $ltsource, $subid, $id_st, $number;

    function __construct(){
      $this->lttracking = ""; $this->ltsource = ""; $this->subid = "";

      $this->id_st = isset($_GET['id_st']) ? $_GET['id_st'] : 1;

      $this->number = false;
    }

    function getSaveData(){
      if( !empty($_COOKIE) ){ $this->getCookieData(); }

      if( !empty($_GET) ) { $this->getLttrackingLtsourceSubid(); }
    }

    function getCookieData(){
      foreach ($_COOKIE as $name => $data){

        if(isset($this->$name)){ $this->$name = $data; }

      }
    }

    function getLttrackingLtsourceSubid(){

      $this->saveDaraArray(array('lttracking', 'ltsource', 'subid'));

      $this->getSubidSaveCookie();
    }

    function saveDaraArray($nameGetArray){
      foreach ($nameGetArray as $name) {

        if(isset($_GET[$name])){

          $this->saveCookie($name, strip_tags(trim($_GET[$name])));

        }
      }
    }

    function getSubidSaveCookie(){
      if( isset($_SERVER['HTTP_REFERER']) && !isset($_GET['subid']) ){

        $subidRefererLink = explode("&", $_SERVER['HTTP_REFERER']);

        foreach ($subidRefererLink as $value){

          $match_all = preg_match_all("/subid=(.*)/si", $value, $match);

          if($match_all){

            $this->saveCookie('subid', $match[1][0]);

          }

        }
      }
    }

    function saveCookie($name, $data){
      if( isset($this->$name) ) $this->$name = $data;

      setcookie($name, $data, time() + (60 * 60 * 24 * 30));
    }

    function buildingHrefImg(){
      return "http://t.leadtrade.ru/21.png?lttracking=".$this->lttracking."&ltid=".trim($_COOKIE['number']);
    }
  }

?>