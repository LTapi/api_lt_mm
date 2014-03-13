<?php

  class Get_leadtrade {
    public $lttracking, $ltsource, $subid;

    function __construct(){
      $this->lttracking = ""; $this->ltsource = ""; $this->subid = "";
    }

    function getSaveData(){
      if( !empty($_COOKIE) ){ $this->getCookieData(); }

      if( !empty($_POST) ) {$this->getLttrackingLtsourceSubid(); }
    }

    function getCookieData(){
      foreach ($_COOKIE as $name => $data) {

        if(isset($this->$name)){ $this->$name = $data; }

      }
    }

    function getLttrackingLtsourceSubid(){

      if(isset($_GET['lttracking'])){
        $this->saveCookie( 'lttracking', strip_tags(trim($_GET['lttracking'])));
      }

      if(isset($_GET['ltsource'])){
        $this->saveCookie('ltsource', strip_tags( trim($_GET['ltsource'])));
      }

      if(isset($_GET['subid'])){
        $this->saveCookie('subid', strip_tags( trim($_GET['ltsource'])));
      }

      $this->getSubidSaveCookie();
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
      $this->$name = $data;

      setcookie($name, $data, time() + (60 * 60 * 24 * 30));
    }
  }

?>