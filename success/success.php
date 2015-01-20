<?php
  session_start();

  require_once('../modul/get_leadtrade.php');

  require_once('../modul/send_order.php');

  $leadDataObj = new Get_leadtrade();

  $sendOrderObj = new Send_order();

  $leadDataObj->getSaveData();
?><!DOCTYPE html>
<html>

  <head>

    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">

    <link type="text/css" rel="stylesheet" href="default/css/style.css" />

    <script src="default/js/jquery.min.js"></script>

    <script type="text/javascript" src="default/js/script.js"></script>

    <title>Заявка отправленна</title>

  </head>

  <body>

    <div class="wrap_block_success">

      <div class="block_success">

        <h2>ПОЗДРАВЛЯЕМ! ВАШ ЗАКАЗ №<?php echo $_SESSION['number']; ?> ПРИНЯТ!</h2>

        <a href="/success/moreinfo.php" class="url_more_info">Нажмите здесь для получения более подробной информации о заказе</a>

        <img width="1" height="1" src="<?php echo $leadDataObj->buildingHrefImg(); ?>" />

        <p class="success">В ближайшее время с вами свяжется оператор для подтверждения заказа. Пожалуйста, включите ваш контактный телефон.</p>

        <h3>Пожалуйста, проверьте правильность введенной вами информации</h3>

        <div class="wrap_list_info">

          <ul class="list_info">

            <li><span>Ф.И.O.: </span><?php echo $_SESSION['data']['name']; ?></li>

            <li><span>Адрес: </span><?php echo $_SESSION['data']['adress']; ?></li>

            <li><span>Телефон: </span><?php echo $_SESSION['data']['phone']; ?></li>

          </ul>
        </div>

        <p class="fail">Если вы ошиблись при заполнени формы, то, пожалуйста, <a href="/?id_st=59">заполните заявку еще раз</a></p>

        <h3>Для получения специальных предложений оставьте адрес электронной почты</h3>

        <form class="email" onsubmit="return false;">

          <span class="error" id="error_mail"></span>

          <div class="mail_block">

            <input type="text" name="email" id="email" />

            <input type="hidden" name="ltsource" id="ltsource"  value="<?php echo $leadDataObj->lttracking; ?>">

            <input type="hidden" name="id_usr" id="id_usr" value="<?php echo $_SESSION['id_usr']; ?>" />

            <input type="hidden" name="id_st" id="id_st" value="60" />

            <a class="button" href="javascript:void(0)" onclick="checkForm();return false;">Отправить</a>

          </div>

        </form>

      </div>

    </div>

  </body>

</html>