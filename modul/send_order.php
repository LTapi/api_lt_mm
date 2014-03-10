<?php

  class Send_order {
    public $pass, $submitUrl, $numberUrl, $number, $user;

    function __construct(){
      $this->pass = "jfTntHcdOf";

      $this->submitUrl = 'http://moneymakerz.ru/_shared/submit_form/';

      $this->numberUrl = 'http://moneymakerz.ru/xmlparse/postnumber/';

      $this->user = 1;

    }

    function sendDataGeneralSystem(){
      if( isset($_POST['lead'])){

        $this->processingMethodTrimStripslashes();

        return $this->getCurlData($this->setDefaultData(), $this->submitUrl);
      }

      return $this->returnGeneralPage();
    }

    function processingMethodTrimStripslashes(){
      foreach ($_POST as $key => $value) {

        $_POST[$key] = stripslashes(trim($value));

      }
    }

    function setDefaultData(){
      $this->number = $this->getCurlData( array('pass' => $this->pass), $this->numberUrl );

      $this->setDefaultPost( array('user' , 'lead', 'subid', 'name', 'index', 'adress', 'phone', 'country', 'city', 'quantity', 'productsum', 'delivery', 'totalsum') );

      $this->checkUserData();

      return array(
        'lead'=> $_POST['lead'],

        'number'=> $this->number,

        'subid' => $_POST['subid'],

        'domain'=> $_SERVER['SERVER_NAME'],

        'id_st'=> 1,

        'id_usr'=> !empty($_POST['user']) ? (int) $_POST['user'] : $this->user,

        'data' => array(
          'name' => $_POST['name'],
          'index' => $_POST['index'],
          'adress' => $_POST['adress'],
          'phone' => $_POST['phone'],
          'country' => $_POST['country'],
          'city' => $_POST['city'],
          'quantity' => $_POST['quantity'],
          'productsum' => $_POST['productsum'],
          'delivery' => $_POST['delivery'],
          'totalsum' => $_POST['totalsum'],
        )
      );
    }

    function setDefaultPost($keyDataArray){

      foreach ($keyDataArray as $key => $value) {

        if( !isset($_POST[$value]) || empty($_POST[$value]) ){ $_POST[$value] = ""; }

      }

    }

    function checkUserData(){
      if( empty($_POST['name']) && empty($_POST['phone']) ){

        return $this->returnGeneralPage();

      }
    }

    function checkNumber(){

      if( !empty($sendOrderObj->number) ){

        return $this->returnGeneralPage();

      }

    }

    function getCurlData($data, $url){

      if( $curl=curl_init() ){

        curl_setopt($curl, CURLOPT_SSLVERSION,3);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);

        curl_setopt($curl, CURLOPT_POST, true);

        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)"); 

        curl_setopt($curl, CURLOPT_URL, $url);

        $returnCurlData = curl_exec($curl);

        curl_close($curl);
      }

      return $returnCurlData;
    }

    function returnGeneralPage(){

      header('Location: http://'.$_SERVER['HTTP_HOST']."/");
      exit();
    }
  }
?>