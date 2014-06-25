<?php
  session_start();

  require_once('../modul/send_order.php');

  $sendOrderObj = new Send_order();

  $sendOrderObj->sendDataGeneralSystem();

  header("Location: http://".$_SERVER['HTTP_HOST']."/success/success.php");
?>
