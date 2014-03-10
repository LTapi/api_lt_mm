<?php
  require_once('modul/get_leadtrade.php');

  $leadDataObj = new Get_leadtrade();

  $leadDataObj->getSaveData();

?><!DOCTYPE html>
<html>
<head>

  <meta http-equiv="Content-Type" content="text/html;charset=utf-8">

  <title>Тестовый домен</title>

  <link rel="stylesheet" type="text/css" href="css/style.css" media="all">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
  
  <script type="text/javascript" src="js/script.js"></script>
</head>
<body>

<form action="/success/" method="post" id="order_all" name="order_all">
  
  <div class="blue_block" id="form">
    
    <div class="blue_block_background">
      
      <div class="blue_block_background_bottom">
        
        <div class="zakaz_forma" id="order_form">

          <table cellpadding="0" cellspacing="0">
            <tbody>

              <tr>
                <td>Страна: <i></i></td>
                <td class="fcont">
                  <select name="country" id="country" data-old-price="3500" data-price="1650" data-delivery="180" data-s-product="88" data-s-kff="1" data-nds="169">
                    <option curs="1" value="RU" data-ccode="rus" data-ccurs="1" selected="selected">Россия</option>
                    <option curs="249.9" value="BY" data-ccode="blr" data-ccurs="249.9">Беларусь</option>
                    <option curs="5.3" value="KZ" data-ccode="kaz" data-ccurs="5.3">Казахстан</option>
                    <option curs="0.293" value="UA" data-ccode="ukr" data-ccurs="0.293">Украина</option>
                  </select>
                </td>
              </tr>

              <tr>
                <td>Полный адрес: <i>*</i></td>
                <td class="fcont">
                  <input value="" name="adress" id="adress" required="" type="text"><br>
                  <div class="message_element">
                    <span id="note_address">Пример: <b>135999, Москва, ул.Ленина д.10 кв.5</b></span>
                    <div style="margin-top: 8px;"><span id="error_address" class="err_note hide"></span></div>
                  </div>
                </td>
              </tr>

              <tr>
                <td>Фамилия Имя Отчество: <i>*</i></td>
                <td class="fcont">
                  <input value="" name="name" id="name" required="" type="text"><br>
                  <div class="message_element">
                    <span id="note_name">Пример: <b>Иванова Анна Петровна</b></span>
                    <div style="margin-top: 8px;"><span id="error_name" class="err_note hide"></span></div>
                  </div>
                </td>
              </tr>

              <tr>
                <td>Телефон (с кодом): <i>*</i></td>
                <td class="fcont">
                  <input value="" name="phone" id="phone" data-check="1" type="text">
                  <div class="message_element">
                    <span id="note_phone">Пример: <b>+79602226688</b></span>
                    <div style="margin-top: 8px;"><span id="error_phone" class="err_note hide"></span></div>
                  </div>
                </td>
              </tr>

              <tr>
                <td>Ваш заказ: <i></i></td>
                <td class="fcont summ_font">
                  <div class="message_element your_order">
                    <span class="new_price_load">1650 руб.</span> + доставка (<span class="delivery_load">180 руб.</span>) + НДС + почтовый сбор
                  </div>
                </td>
              </tr>
              
              <tr>
                <td>ИТОГО: <i></i></td>
                <td class="fcont summ_font">
                  <div class="message_element total_order">
                    <span class="summ_load">1999 руб.</span>
                    <input type="hidden" id="int-s-new_price" readonly="readonly" name="productsum" value="1650 руб." class="bg_input">
                    <input type="hidden" id="int-s-delivery" readonly="readonly" name="delivery" value="180 руб." class="bg_input">
                    <input type="hidden" id="int-s-ttl" readonly="readonly" name="totalsum" value="1999 руб." class="bg_input_summ">
                  </div>
                </td>
              </tr>

            </tbody>
        </table>
        <hr class="order_line">

        <input type="hidden" name="lead" value="<?php echo $leadDataObj->lttracking.".".$leadDataObj->ltsource; ?>" />

        <input type="hidden" name="subid" value="<?php echo $leadDataObj->subid; ?>" />

        <a class="order_button" href="javascript:void(0)" onclick="finish_shoppings(event);return false;">
          Оформить Заказ
        </a>

      </div>

    </div>

  </div>

  </div>
</form>

</body>

</html>