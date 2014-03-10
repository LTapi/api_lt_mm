// Проверка на введенные числа
String.prototype.hasPhoneRegExp = function(){
  var str = this.substr(0,1); 
  var str_2 = this.substr(0,2);
  if( this.length > 4 ){
	return true;
  }
  return false;
};

function finish_shoppings(form){
  var dataForm = {};

  var errorMessage = {
    'user_name'  : 'Имя должно быть заполненно',
    'user_phone' : 'Необходимо ввести номер телефона',
    'user_adres' : 'Поле с почтовым адресом должно быть заполненно',
    'phone_enter' : 'Должно быть введено больше 5 цифр'
  }

  // Подготовливаем данные
  var input_count = $('input', $(form)).length - 4;

  for(var i=0; i < input_count; i++){
		input = $('input', $(form))[i];
		
		if( $(input).attr('type') == 'checkbox' ){
			
			dataForm[$(input).attr('name')] = Number( $(input).is(":checked") );
			
		} else {
			
			dataForm[$(input).attr('name')] = $.trim( $(input).val() );
			
		}
  }
  
  for (var val in dataForm){
    
    if (dataForm[val] == "") {
      
			alert(errorMessage[val]);
			
      return false;
		
    }
    
    if(val == 'user_phone'){
      if (!dataForm[val].hasPhoneRegExp()) {
        alert(errorMessage.phone_enter);
        return false;
      }
    }
    
  }

  var form = document.getElementById("order_all");

  //$(".order_button").addEventListener("click", function () {
    form.submit();
  //});
  return true;
}