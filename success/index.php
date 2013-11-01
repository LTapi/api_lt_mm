<?php
    
    require_once('../modul_actionpay/actionpay.php');
    $obj_conversions = new Surveillance_conversions();
    $number = $obj_conversions->data_add();
    
    $data_arr = $obj_conversions->order_success($number);
    if(!empty($data_arr['actionpay'])){
        $data_lt = explode(".",$data_arr['actionpay']);
    }
    
    // Проверяем данные на наличее дублей
    $pix_status = $obj_conversions->incorrect_view();
    
    $domain = $_SERVER['HTTP_HOST'];
    header("Location: http://".$domain."/success/success.php?actionpay=".$data_lt[0]."&number=".$data_arr['number']."&pix=".$pix_status);
?>