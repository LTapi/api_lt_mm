cntry_selector = '#country';
quantity_selector = '#int_product_count';

$(document).ready(function() {
  $(cntry_selector).change( function() {
    upd_int();
  });
  $(quantity_selector).keyup(function() {
    if ($(this).val() < 1) {
      $(this).val(1);
    }
    upd_int();
  });

  $('.form_input').focus(function(){

    $(this).next('.fhelp').children('.err_note').hide().siblings('.example').show();
  });
 });

function upd_int() {
  curs  = $(cntry_selector).children(":selected").val();
  count   = $(quantity_selector).val();

  if($.isNumeric(count)) {

    count   = $(quantity_selector).val();

  } else {

    count = 1;

  }

  prod_info = $jsonData.prices[curs];

  total = (prod_info.price + prod_info.delivery_price + prod_info.tax_price);

  $(".int_price_show").text(prod_info.price * count + " " + prod_info.currency);

  $(".int_price_delivery").text(prod_info.delivery_price * count + " " + prod_info.currency);

  $(".int_price_total").text(total * count + " " + prod_info.currency);

  $(".int_price_old").text(prod_info.old_price * count + " " + prod_info.currency);

  $("#product_count").val(count);
  $("#note_name b").text(prod_info.name_template);
  $("#note_phone b").text(prod_info.phone_template);
  $("#note_address b").text(prod_info.address_template);
}