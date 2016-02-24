<?php
  session_start();

  if(time() - @$_SESSION['start_visit'] > 10) {

      require_once('../modul/send_order.php');
      require_once('../modul/get_leadtrade.php');

      $leadDataObj = new Get_leadtrade();

      if(!isset($_SESSION['was_lead']) or $_SESSION['was_lead'] != $leadDataObj->lttracking) {

           $_SESSION['was_lead'] = $leadDataObj->lttracking;

           $sendOrderObj = new Send_order();

           $sendOrderObj->sendDataGeneralSystem();

           header("Location: http://".$_SERVER['HTTP_HOST']."/success/success.php");

       } else {

           header("Location: http://".$_SERVER['HTTP_HOST']."/success/sorry.php");
      }

  }
  ?>