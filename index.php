<?php

  session_start();

  require_once('modul/get_leadtrade.php');

  $leadDataObj = new Get_leadtrade();

  $leadDataObj->getSaveData();

  $validData = $leadDataObj->getUserRepeatData();

  $leadDataObj->setRate($RU = 1, $BY = 0.0037, $KZ = 0.21, $UA = 3);

  $leadDataObj->setRuSumm($totalsum = '1980', $productsum = '1650', $delivery = '180', $oldproductsum = '3200');
?><!DOCTYPE html>
<html>
<head>

  <meta http-equiv="Content-Type" content="text/html;charset=utf-8">

  <title>Тестовый домен</title>

  <link rel="stylesheet" type="text/css" href="css/style.css" media="all">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>

  <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

  <script type="text/javascript" src="/js/valid_form.js"></script>

  <script type="text/javascript" src="/js/script.js"></script>

  <script type="text/javascript">
    $jsonData = <?php echo json_encode($GLOBALS['pricesJson']); ?>
  </script>
</head>
<body>

<form action="/success/" method="post" id="order_all" name="order_all">
  <div class="order_form">
    <div class="block_form">
      <label>Страна:</label>
      <select name="country" class='countryselect'>
        <?php echo $leadDataObj->getSelectChangeCurentCountry(); ?>
      </select>
    </div>

    <div class="block_form">
      <label>Полный адрес:</label>
      <div>
        <input class="form_input" name="adress" id="address" type="text" value="<?php echo $validData['adress']; ?>" required>
        <span class="fhelp"><span class="example" id="note_address">Пример: <b>135999, Москва, ул. Ленина, д.10, кв.5</b></span>
        <span id="error_address" class="err_note hide"></span></span>
      </div>
    </div>

    <div class="block_form">
      <label>Фамилия Имя Отчество:</label>
      <div>
        <input class="form_input" name="name" id="name" type="text" value="<?php echo $validData['name']; ?>" required>
        <span class="fhelp"><span class="example" id="note_name">Пример: <b>Петров Петр Петрович</b></span>
        <span id="error_name" class="err_note hide"></span></span>
      </div>
    </div>

    <div class="block_form">
      <label>Телефон (с кодом):</label>
      <div>
        <input class="form_input" name="phone" id="phone" type="text" value="<?php echo $validData['phone']; ?>" >
        <span class="fhelp"><span class="example" id="note_phone">Пример: <b>+7 928 827-22-53</b> (международный формат)</span>
        <span id="error_phone" class="err_note hide"></span></span>
      </div>
    </div>

    <div class="block_form block_form_prices">
      <label>Ваш заказ:</label>

      <p><span class="productsum">999 руб.</span> <span class="delivery">доставка</span> + НДС</p>

    </div>

    <div class="form_hr"></div>

    <div class="block_form block_form_prices block_form_prices_total">

      <label>ИТОГО:</label>

      <p class="totalsum">1280 руб.</p>
    </div>
  </div>

  <input type="hidden" name="productsum" value="1650 руб." />

  <input type="hidden" name="delivery" value="180 руб." />

  <input type="hidden" name="totalsum" value="1980 руб." />

  <input type="hidden" name="lead" value="<?php echo $leadDataObj->lttracking.".".$leadDataObj->ltsource; ?>" />

  <input type="hidden" name="subid" value="<?php echo $leadDataObj->subid; ?>" />

  <input type="hidden" name="id_st" value="<?php echo $leadDataObj->id_st; ?>" />

  <input type="hidden" name="product" value="gingergoji" />

  <input type="hidden" name="user" value="1" />

  <a class="ifr_button" href="javascript:void(0)" onclick="checkFields(event, this);">Оформить Заказ</a>

</form>

<div>
  Старая цена <span class="oldproductsum"></span>
</div>
</body>