<?php
  require_once('get_leadtrade.php');

  class Send_order extends Get_leadtrade {
    public $pass, $submitUrl, $numberUrl, $number, $user;

    private static $instance = null;

    public static function getInstance(){

      if (null === self::$instance){

        self::$instance = new self();

      }

      return self::$instance;
    }

    function __construct(){
      $this->pass = "jfTntHcdOf";

      $this->submitUrl = 'http://moneymakerz.ru/_shared/submit_form/';

      $this->numberUrl = 'http://moneymakerz.ru/xmlparse/postnumber/';

      $this->getdataUrl = 'http://moneymakerz.ru/_shared/get_data/';

      $this->setMailDeals = 'http://moneymakerz.ru/_shared/order_deals/';

      $this->user = 1;
    }

    function sendDataGeneralSystem(){
      if( isset($_POST['lead'])){

        $this->processingMethodTrimStripslashes();

        return $this->getCurlData($this->checkReplyStatus($this->setDefaultData()), $this->submitUrl);
      }

      return $this->returnGeneralPage();
    }

    function processingMethodTrimStripslashes(){
      foreach ($_POST as $key => $value) {

        $_POST[$key] = stripslashes(trim($value));

      }
    }

    function setDefaultData(){
      $this->getNumber();

      $this->saveCookie('number', $this->number);

      $this->checkValidationData(array('name', 'adress', 'phone'));

      $this->setDefaultPost(array('user' , 'lead', 'subid', 'name', 'index', 'adress', 'phone', 'country', 'city', 'quantity', 'productsum', 'delivery', 'totalsum'));

      $this->checkUserData();

      return array(
        'lead'=> $_POST['lead'],

        'number'=> $this->number,

        'subid' => $_POST['subid'],

        'domain'=> $_SERVER['SERVER_NAME'],

        'id_st'=> $_POST['id_st'],

        'id_usr'=> !empty($_POST['user']) ? (int) $_POST['user'] : $this->user,

        'product' => (isset($_POST['product'])) ? strip_tags(trim($_POST['product'])) : 'indefinitely',

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

    function getNumber(){
      $this->number = $this->getCurlData( array('pass' => $this->pass), $this->numberUrl );
    }

    function checkValidationData($methodInputArray){
      foreach ($methodInputArray as $inputName) {

        if(method_exists('Validation', $inputName) && isset($_POST[$inputName])){

          if($this->$inputName($_POST[$inputName])) return $this->returnGeneralPageThisValidation($methodInputArray);

        }
      }

      return true;
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

    function checkReplyStatus($defaultData){
      if( !$this->number ){

        $fp = fopen(dirname(__FILE__)."/backup/backup.csv", "a+");

        $content = array( date("d/m/Y H:m").';'.$defaultData['lead'].';'.json_encode($defaultData['data']).'\r\n' );

        fputcsv($fp, $content);

        fclose($fp);
      }

      return $defaultData;
    }

    function getDefaultData($number){
      if($number) return unserialize($this->getCurlData(array('number' => trim($number)), $this->getdataUrl));

      return false;
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

        return $returnCurlData;
      }
    }

    function returnGeneralPage(){

      header('Location: http://'.$_SERVER['HTTP_HOST']."/");
      exit();
    }

    function returnGeneralPageThisValidation($methodInputArray){

      foreach ($methodInputArray as $inputName) {

        if(isset($_POST[$inputName])) {

          $getStr[] = $inputName.'='.$_POST[$inputName];

        }

      }

      header('Location: http://'.$_SERVER['HTTP_HOST']."/?".implode("&", $getStr));
      exit();
    }
  }
?>