<?php


include "../connect.php";
$ordersrating= filterRequest("ordersrating");
$ordersnotrating= filterRequest("ordersnotrating");
$ordersid= filterRequest("ordersid");

$data = array(
    "orders_rating"=>$ordersrating,// nanme colum in musql == var username
    "orders_notrating"=>$ordersnotrating,
  
);
    
updateData('orders', $data,"orders_id = $ordersid");
  