<?php
  require_once('init.php');

  require_once('validation.php');

  require_once(dirname(dirname(__FILE__)).'/_api/sxgeo.php');

  require_once(dirname(dirname(__FILE__)).'/helper/select_define_builder.php');

  class Get_leadtrade extends Validation {

    public $lttracking, $ltsource, $subid, $id_st, $cbrNominalArr, $defaultNominalRate, $countries;

    function __construct(){
      $this->lttracking = ""; $this->ltsource = ""; $this->subid = "";

      $this->id_st = isset($_GET['id_st']) ? $_GET['id_st'] : 1;

      $this->defaultNominalRate = array('RU' => 1, 'BY' => 1, 'KZ' => 1, 'UA' => 1, 'MDA' => 1);


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

    function setSessionPostData($userData){
      foreach ($userData as $key => $value) { $_SESSION[$key] = $value; }
    }

    function getUserRepeatData(){
      return array(
        'name' => isset($_SESSION['data']['name']) ? $_SESSION['data']['name'] : "",

        'adress' => isset($_SESSION['data']['adress']) ? $_SESSION['data']['adress'] : "",

        'phone' => isset($_SESSION['data']['phone']) ? $_SESSION['data']['phone'] : ""
      );
    }

    function buildingHrefImg(){
     $countries = $this->getaim();
      return "http://t.leadtrade.ru/21.png?lttracking=".$this->lttracking."&ltid=".trim($_SESSION['number'])."&aim=".$countries[$_SESSION['data']['country']];
    }


    /*
     * Select Country builder, get current location, use sxgeo DB
    */
    function getSelectChangeCurentCountry(){
      return select_define_builder(array($this->getCountry()), $this->getCountryValueName(), true);
    }

    function getCountry(){
      $sxGeo = new SxGeo('_api/sxgeocity.dat');

      $dataGeo = $sxGeo->get($_SERVER['HTTP_X_REAL_IP']);

      return $dataGeo['country']['iso'];
    }

    function getCountryValueName(){
      return array("RU" => "Россия", "BY" => "Беларусь", "UA" => "Украина", "KZ" => "Казахстан", "MDA" => "Молдова");
    }


function getaim() {
return array("RU" =>"1", "BY" => "2", "KZ" => "3", "UA" => "4", "MDA" => "5");

}



    /*
     * Set Local price for Form
    */
    function setRate($RU = 0, $BY = 0, $KZ = 0, $UA = 0, $MDA = 0){
      return $this->defaultNominalRate = array('RU' => $RU, 'BY' => $BY, 'KZ' => $KZ, 'UA' => $UA, 'MDA' => $MDA);
    }

    function setRuSumm($totalsum = 0, $productsum = 0, $delivery = 0, $oldproductsum = 0){

      foreach ($GLOBALS['pricesJson'] as $countryIso => $sumData) {

        $GLOBALS['pricesJson'][$countryIso]['totalsum'] = $this->getSum($totalsum, $countryIso);

        $GLOBALS['pricesJson'][$countryIso]['productsum'] = $this->getSum($productsum, $countryIso);

        $GLOBALS['pricesJson'][$countryIso]['delivery'] = $this->getSum($delivery, $countryIso);

        $GLOBALS['pricesJson'][$countryIso]['oldproductsum'] = $this->getSum($oldproductsum, $countryIso);
      }
    }

    function getSum($sum, $countryIso){ return round($sum * $this->defaultNominalRate[$countryIso]); }


  }
?>