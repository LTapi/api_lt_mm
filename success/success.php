<?php
    require_once('../modul_actionpay/actionpay.php');
    $obj_conversions = new Surveillance_conversions();
    
    if(isset($_GET['number'])){
        $number=$_GET['number'];
        $actionpay="";
        if(!empty($_GET['actionpay'])){
            $actionpay=$_GET['actionpay'];
        }else{
            $lttracking = $obj_conversions->tizid_extract();
            $ltsource = $obj_conversions->ltsource_extract();
            if(!empty($lttracking)){
                $actionpay = $lttracking.".".$ltsource;
            }
        }
    }else{
        $domain = $_SERVER['HTTP_HOST'];
        header("Location: http://".$domain."/");
    }
?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Заявка отправленна</title>
</head>
<body>

	<h2><b>Поздравляем! Номер заказа: <strong>#<?php echo $number; ?></strong></h2>
	<?php if($_GET['pix']){ ?>
	    <img width="1" height="1" src="http://t.leadtrade.ru/21.png?lttracking=<?php echo !empty($actionpay) ? $actionpay : ""; ?>&ltid=<?php echo $number; ?>" />
	<?php } ?>
</body>
</html>