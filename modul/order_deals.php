<?php
  require_once('send_order.php');
  require_once('validation.php');

  class Order_deals extends Validation {
    function __construct(){}

    function saveMailDeals(){
      if($this->email($_POST['data']['email'])) return false;

      Send_order::getInstance()->getNumber();

      $_POST['number'] = Send_order::getInstance()->number;

      return Send_order::getInstance()->getCurlData($_POST, Send_order::getInstance()->setMailDeals);
    }
  }
?>