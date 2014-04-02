<?php
  require_once('modul/get_leadtrade.php');

  $leadDataObj = new Get_leadtrade();

  $leadDataObj->getSaveData();

  $validData = $leadDataObj->getValidData();
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
    $jsonData = {"product":{"id":314,"title":"Ягоды для похудения","short_description":"Годжи - чудо природы, ягоды для похудения","full_description":"Годжи - чудо природы\r\nВ этой маленькой ягодке содержится 18 аминокислот, 8 из которых - незаменимы, 21 минерал, витамины Е, С, В1, В2, В6, каротин, полисахариды и огромное количество других полезных составляющих. Включение этой ягоды в рацион будет полезно и тем, кто решил похудеть, и тем, кто хочет поддержать вес, и тем, кто просто хочет укрепить здоровье."},"prices":{"UA":{"price":290,"old_price":600,"delivery_price":30,"tax_price":0,"upsale_price":0,"geo_key":"UA","name":"Украина","currency":"грн.","rate":0.37,"phone_template":"+38 067 927 25 74","address_template":"01024, г. Киев, ул. Богомольца, д.5, кв.9","name_template":"Карпенко Ярослав Федорович","active":false},"RU":{"price":999,"old_price":2000,"delivery_price":281,"tax_price":0,"upsale_price":0,"geo_key":"RU","name":"Россия","currency":"руб.","rate":1,"phone_template":"+7 928 827-22-53","address_template":"135999, Москва, ул. Ленина, д.10, кв.5","name_template":"Петров Петр Петрович","active":true},"KZ":{"price":5635,"old_price":11000,"delivery_price":920,"tax_price":0,"upsale_price":0,"geo_key":"KZ","name":"Казахстан","currency":"тенге","rate":5.3,"phone_template":"+7 705 1301111","address_template":"ул. Майлина, д.3, кв. 6, г. Костанай, 110003","name_template":"Алтынбаев Азат Тюлегенович","active":false},"BY":{"price":350000,"old_price":700000,"delivery_price":40000,"tax_price":0,"upsale_price":0,"geo_key":"BY","name":"Беларусь","currency":"бел. руб.","rate":280,"phone_template":"+37 529 186 24 65","address_template":"220035, г. Минск, пр-т Машерова, д. 76, кв. 17","name_template":"Матвеев Евгений Алексеевич","active":false}},"lowPrice":{"year":"2014","month":"03","day":"31"}};
  </script>
</head>
<body>

<form action="/success/" method="post" id="order_all" name="order_all">
  <div class="order_form">
    <div class="block_form">
      <label>Страна:</label>
      <select name="country" id='country'>
        <option value='UA'>Украина</option>
        <option value='RU' selected="selected">Россия</option>
        <option value='KZ'>Казахстан</option>
        <option value='BY'>Беларусь</option>
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

      <p><span class="int_price_show">999 руб.</span> + доставка + НДС</p>

    </div>
      
    <div class="form_hr"></div>
      
    <div class="block_form block_form_prices block_form_prices_total">
        
      <label>ИТОГО:</label>
        
      <p class="int_price_total">1280 руб.</p>
    </div>
  </div>

  <input type="hidden" name="productsum" value="180 руб." class="int_price_delivery" />

  <input type="hidden" name="delivery" value="1650 руб." class="int_price_show" />

  <input type="hidden" name="totalsum" value="1980 руб." class="int_price_total" />

  <input type="hidden" name="lead" value="<?php echo $leadDataObj->lttracking.".".$leadDataObj->ltsource; ?>" />

  <input type="hidden" name="subid" value="<?php echo $leadDataObj->subid; ?>" />

  <input type="hidden" name="id_st" value="<?php echo $leadDataObj->id_st; ?>" />

  <input type="hidden" name="user" value="1" />

  <a class="ifr_button" href="javascript:void(0)" onclick="checkFields(event, this);">Оформить Заказ</a>

</form>

</body>

</html>