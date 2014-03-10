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

      <img width="1" height="1" src="http://t.leadtrade.ru/21.png?lttracking=<?php echo $leadDataObj->lttracking.".".$leadDataObj->ltsource; ?>&ltid=<?php echo $_GET['number']; ?>" />

  </body>

</html>