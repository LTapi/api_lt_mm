<?php
    /**
     * Surveillance_conversions - запись в COOKIE данных
     * полученных от источника GET зараметров ActionPay
    */
    class Surveillance_conversions {
        private $text_file;
        protected $pass;
        public $domain;
        public $name;
        public $phone;
        public $adress;
        public $incorrect;
        
        function __construct(){
            $this->text_file = 'number.txt';
            $this->pass="jfTntHcdOf";
            $this->domain=$_SERVER['HTTP_HOST'];
            $this->incorrect=0;
        }
        
        /**
         * conversions_add() извлекаем GET параметры, запись в COOKIE
         * используеться "Полная форма" сети ActionPay
        */
        function conversions_add(){
            // Если пользователь с таким тизером зашел в первый раз мы его записываем.
            if(isset($_GET['lttracking'])){
                $lttracking = strip_tags(trim($_GET['lttracking']));
                setcookie('lttracking', $lttracking, time() + (60 * 60 * 24 * 30));
            }
        }
        
        function conversions_ltsource(){
            // Если пользователь с таким тизером зашел в первый раз мы его записываем.
            if( isset($_GET['ltsource']) ){
                $ltsource = strip_tags( trim($_GET['ltsource']) );
                setcookie( 'ltsource', $ltsource, time() + (60 * 60 * 24 * 30) );
            }
        }
        
        function subid_save_cookie(){
            $get_subid = explode("&", $_SERVER['HTTP_REFERER']);
            
            foreach ($get_subid as $value){
                $match_all = preg_match_all("/subid=(.*)/si", $value, $match);
                if($match_all){
                    $subid = $match[1][0];
                }
            }
            if(isset($subid)){
                setcookie('subid', $subid, time() + (60 * 60 * 24 * 30));
            }
        }
        
        /**
         * Извдекаем из кук данные
         * return $lttracking
        */
        function tizid_extract(){
            if(isset($_COOKIE['lttracking'])){
                $lttracking = $_COOKIE['lttracking']; // уникальный идентификатор перехода
            }
            return $lttracking;
        }
        function ltsource_extract(){
            $ltsource = false;
            if( isset( $_COOKIE['ltsource']) ){
                $ltsource = $_COOKIE['ltsource']; // уникальный идентификатор перехода
            }
            return $ltsource;
        }
        function subid_extract(){
            $subid = false;
            if( isset( $_COOKIE['subid']) ){
                $subid = $_COOKIE['subid']; // уникальный идентификатор перехода
            }
            return $subid;
        }
        
        /**
         * Форма успешно оформленного заказа
        */
        function order_success($number){
            if(!empty($number)){
                $number = $number;
                $actionpay = $_POST['actionpay'];
                
                // Формируем данные для изображения
                $data_arr = array(
                    'number' => $number,
                    'actionpay' => $actionpay
                );
                return $data_arr;
            }else{
                header('Location: '.$this->domain.'#order');
            }
            return false;
        }
        
        /**
         * Акция по дате на iPhone
        */
        function date_gift(){
            $date_arr = array(
                'января', 'февраля', 'марта', 'апреля', 'майя', 'июня', 'июля', 'августа', 'сентября', 'ноября', 'октября', 'декабря'
            );
            $month = date('m');
            if( !substr($month, 0, 1) ){
                $month = substr($month, -1);
            }
            return 'с '.(date( 'd', time()- 60*60*24*7))." по ".date('d').' '.$date_arr[$month-1]." ".date('Y')." года ";
        }
        
        function date_gift_to(){
            $date_arr = array(
                'января', 'февраля', 'марта', 'апреля', 'майя', 'июня', 'июля', 'августа', 'сентября', 'ноября', 'октября', 'декабря'
            );
            $month = date('m');
            if( !substr($month, 0, 1) ){
                $month = substr($month, -1);
            }
            return (date( 'd', time() + 60*60*24)).' '.$date_arr[$month-1]." ".date('Y')." года ";
        }
        
        /**
         * Извлекаем из БД последний номер заявки, добавляем его к apid
        */
        function apid(){
            // Пароль в md5(), извлекаем последний номер
            $data_arr=array(
                'pass'=>$this->pass
            );
            
            // отправка данных curl
            if($curl=curl_init()){
                $submit_url = 'http://moneymakerz.ru/xmlparse/postnumber/';
                curl_setopt($curl, CURLOPT_SSLVERSION,3); 
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); 
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); 
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data_arr));
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)"); 
                curl_setopt($curl, CURLOPT_URL, $submit_url); 
                $number=curl_exec($curl);
                curl_close($curl);
            }
            return $number;
        }
        
        /**
         * Сохраняем данные формы и передаем их COORL-ом
        */
        function data_add(){
            if( isset($_POST['actionpay'])){
                // Получаем subid
                $subid = ( !empty($_POST['subid']) ) ? trim($_POST['subid']) : $this->subid_extract();
                
                // Получаем информацию с формы
                $actionpay = ( !empty($_POST['actionpay']) ) ? trim($_POST['actionpay']) : $this->tizid_extract.".".$this->ltsource_extract();
                $number = $this->apid();
                $this->name = htmlspecialchars(trim($_POST['user_name']));
                $this->phone = htmlspecialchars(trim($_POST['user_phone']));
                $this->adress = htmlspecialchars(trim($_POST['user_adres']));
                $email = htmlspecialchars(trim($_POST['email']));
                $total_price = htmlspecialchars(trim($_POST['s3']));
                
                // Проверка данных на дубли страницы
                $this->doubles_error_data();
                //if(!$this->incorrect){
                //    $id_st = 19;
                //}else{
                    $id_st = 1;
                //}
                
               
                // Формируем массив данных
                $data_arr = array(
                    'actionpay'=>$actionpay,
                    'number'=>$number,
                    'subid' => $subid,
                    'domain'=>$_SERVER['SERVER_NAME'],
                    'id_st'=>$id_st,
                    'id_usr'=> 3,
                    'data_order' => array(
                        'val_0'=>$this->name, 'lab_0'=>'Имя: ',
                        'val_1'=>$this->phone, 'lab_1'=>'Телефон: ',
                        'val_2'=>$this->adress, 'lab_2'=>'Полный адрес: ',
                        'val_3'=>$total_price, 'lab_3'=>'Итого по заказу: '
                    )
                );
                
                // отправка данных curl
                if( $curl=curl_init() ){
                    curl_setopt($curl, CURLOPT_URL, 'http://moneymakerz.ru/data_add/');
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data_arr));
                    curl_exec($curl);
                    curl_close($curl);
                }
                
                return $number;
            }
        }
        
        /*
         * Проверка данных на на дубли страницы
        */
        function doubles_error_data(){
            if(!empty($this->adress) && !empty($this->phone)){
                $data_doubles = array(
                    'name' => $this->name,
                    'phone' => $this->phone,
                    'pass'=> md5($this->pass)
                );
                
                // отправка данных curl
                if($curl=curl_init()){
                    $submit_url = 'http://moneymakerz.ru/doubles_error_data/error_data_pages/';
                    curl_setopt($curl, CURLOPT_SSLVERSION,3); 
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); 
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); 
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data_doubles));
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)"); 
                    curl_setopt($curl, CURLOPT_URL, $submit_url); 
                    $this->incorrect = curl_exec($curl);
                    curl_close($curl);
                }
            }
        }
        
        // Вывод значения для пикселя(0 - невыводить, 1 - выводить)
        function incorrect_view(){
            //return $this->incorrect;
            return 1;
        }
        
        // Запись дополнительных данных в БД slender-turbo
        function second_add_data(){
            if(isset($_POST['adress'])){
                
                $data = array(
                    'adress' => htmlspecialchars(trim($_POST['adress'])),
                    'domain' => $_SERVER['SERVER_NAME'],
                    'date_ord' => date('d/m/Y')
                );
                
                $sql = "INSERT INTO `second_add_data` (adress, domain, date_ord) VALUES (:adress, :domain, :date_ord)";
                
                $pdo = $this->connect();
                
                $query = $pdo->prepare($sql);
                
                $query->execute($data);
            }
        }
    }
?>