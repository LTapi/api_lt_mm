<?php
    require_once('../modul/get_leadtrade.php');

    $leadDataObj = new Get_leadtrade();

    $leadDataObj->getSaveData();
?><!DOCTYPE html>
<html>
  <head>

      <meta charset="UTF-8" />

      <link type="text/css" rel="stylesheet" href="default/style.css" />

      <title>Заявка отправленна</title>

  </head>

  <body>

    <div class="wrap_block_success">
      <div class="block_success">

        <h2>Поздравляем! Номер заказа: #<?php echo $_GET['number']; ?></h2>

        <img width="1" height="1" src="<?php echo $leadDataObj->buildingHrefImg(); ?>" />

        <p class="success">В ближайшее время с вами свяжется оператор для подтверждения заказа. Пожалуйста, включите ваш контактный телефон.</p>
      </div>
    </div>

  </body>

</html>