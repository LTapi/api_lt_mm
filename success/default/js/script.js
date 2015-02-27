function checkForm() {

  $("#error_mail").hide();

  if($('#email').val() == ''){

    $("#error_mail").html("Введите адрес электронной почты").show();

  } else {
    
    if(!/.+@.+\..+/i.test($("#email").val())){
      
      $("#error_mail").html("Адрес введен не верно. Пример: \"example@example.ru\"").show();
    
    } else {
      
      $.ajax({
        type: "POST",

        url: "/success/order_deals.php", 

        data: {
            'lead'          : $('#ltsource').val(),

            'domain'        : document.domain,

            'id_usr'        : $('#id_usr').val(),

            'id_st'         : $('#id_st').val(),

            'data'          : {

            'email'       : $('#email').val(),

            'description' : 'Для получения специальных предложений',

            'phone'       : ''
          }
        },

        beforeSend: function(){
          $(".mail_block .button").addClass("disabled");
        },

        success: function(data){

          $(".mail_block").hide();

          $("#error_mail").addClass("mail_s").html("Адрес электронной почты успешно сохранен").show();

        }

      });

    }
  }
}