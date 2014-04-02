<?php
  require_once('../modul/order_deals.php');

  $orderDeals = new Order_deals();

  $orderDeals->saveMailDeals();
?>