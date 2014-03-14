<?php

    require_once('../modul/get_leadtrade.php');

    $leadDataObj = new Get_leadtrade();

    $leadDataObj->getSaveData();
?><!DOCTYPE html>
<html>
  <head>

      <meta charset="UTF-8" />

      <title>Заявка отправленна</title>

  </head>

  <body>

      <h2>Поздравляем! Номер заказа: #<?php echo $_GET['number']; ?></h2>

      <img width="1" height="1" src="<?php echo $leadDataObj->buildingHrefImg(); ?>" />

  </body>

</html>