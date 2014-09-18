<?php
  require_once('init.php');

  require_once('validation.php');

  require_once('./_api/sxgeo.php');

  require_once('./helper/select_define_builder.php');

  class Get_leadtrade extends Validation {
    public $lttracking, $ltsource, $subid, $id_st;

    function __construct(){
      $this->lttracking = ""; $this->ltsource = ""; $this->subid = "";

      $this->id_st = isset($_GET['id_st']) ? $_GET['id_st'] : 1;
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
      return "http://t.leadtrade.ru/21.png?lttracking=".$this->lttracking."&ltid=".trim($_SESSION['number']);
    }

    function getSelectChangeCurentCountry(){
      return select_define_builder(array($this->getCountry()), $this->getCountryValueName(), true);
    }

    function getCountry(){
      $sxGeo = new SxGeo('_api/sxgeocity.dat');

      $dataGeo = $sxGeo->get($_SERVER['REMOTE_ADDR']);

      return $dataGeo['country']['iso'];
    }

    function getCountryValueName(){
      return array("RU" => "Россия", "BY" => "Беларусь", "UA" => "Украина", "KZ" => "Казахстан");
    }

    function setRuSumm($totalsum = 0, $productsum = 0, $delivery = 0){

      $cbrSumArr = $this->getCbrSumArr();

      foreach ($GLOBALS['pricesJson'] as $countryIso => $sumData) {

        $GLOBALS['pricesJson'][$countryIso]['totalsum'] = $this->getSum($cbrSumArr, $totalsum, $countryIso);

        $GLOBALS['pricesJson'][$countryIso]['productsum'] = $this->getSum($cbrSumArr, $productsum, $countryIso);

        $GLOBALS['pricesJson'][$countryIso]['delivery'] = $this->getSum($cbrSumArr, $delivery, $countryIso);
      }
    }

    function getCbrSumArr(){
      $cbrSumArr = array();

      $cbrSumStr = simplexml_load_file("http://www.cbr.ru/scripts/XML_daily.asp?date_req=".date("d/m/Y"));

      if(is_object($cbrSumStr)){

        foreach ($cbrSumStr AS $sum){

          $cbrSumArr[$this->cleanCharCodeRenameCountryCode(strval($sum->CharCode))] = strval($sum->Value);

        }

      }

      return $cbrSumArr;
    }

    function cleanCharCodeRenameCountryCode($charCode, $rateCode = array('BYR' => 'BY', 'UAH' => 'UA', 'KZT' => 'KZ')){
      if( isset($rateCode[$charCode]) ) return $rateCode[$charCode];

      return $charCode;
    }

    function getSum($cbrSumArr, $totalsum, $countryIso){
      if( isset($cbrSumArr[$countryIso]) ) return $cbrSumArr[$countryIso] * $totalsum;

      return intval($totalsum);
    }
  }
?>