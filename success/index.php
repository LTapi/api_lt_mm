<?php

  require_once('../modul/send_order.php');

  $sendOrderObj = new Send_order();

  $sendOrderObj->sendDataGeneralSystem();

  $sendOrderObj->checkNumber();

  header("Location: http://".$_SERVER['HTTP_HOST']."/success/success.php");
?>