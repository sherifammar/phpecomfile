<?php


include "../connect.php";

$usersid= filterRequest("usersid");
$ordersaddress= filterRequest("ordersaddress");
$orderstype= filterRequest("orderstype");
$orderspricedelivery= filterRequest("orderspricedelivery");
$ordersprice= filterRequest("ordersprice");
$orderscoupon= filterRequest("orderscoupon");
$orderspaymentmethod= filterRequest("orderscoupon");
$coupondiscount= filterRequest("coupondiscount");

if ($orderstype == 1) { //if  1 == recive => do not add price of delivery in 
    $orderspricedelivery =0;
}
$totalprice = $ordersprice + $orderspricedelivery;
//=== check coupon

$now= date("Y-m-d h:i:s"); // error => it is time now


//===== "coupon_id = '$orderscoupon'

$checkcoupon = getData("coupon","coupon_id = '$orderscoupon' AND coupon_expiredate > '$now' AND coupon_count > 0" ,null ,false);

if($checkcoupon>0){
    // update of coupon count => decrease 1

$stmt= $con ->prepare("SELECT  `coupon_count` FROM `coupon` WHERE `coupon`.`coupon_id` = '$orderscoupon'");

$stmt->execute();

 $dec = $stmt->fetchColumn();
 $dec =$dec- 1;
//  $dec--;
 //==============

    $totalprice= $totalprice - $totalprice* $coupondiscount/100;
    $stmt=$con->prepare("UPDATE `coupon` SET `coupon_count`= $dec WHERE coupon_id = '$orderscoupon'");
    $stmt->execute();
}
 // ===============

$data = array(
    "orders_usersid"=>$usersid,// nanme colum in musql == var username
    "orders_address"=>$ordersaddress,
    "orders_type"=>$orderstype,
    "orders_pricedelivery"=>$orderspricedelivery,
    "orders_price"=>$ordersprice,
    "orders_coupon"=>$orderscoupon,
    "orders_totalprice"=>$totalprice,
    "orders_paymentmethod"=>$orderspaymentmethod
);
    
// === change cartorder in cart table ( main is order is done and can not delet it)
 $count = insertData('orders',$data,false);
 if ($count>0) {
       $stmt = $con->prepare(" SELECT MAX(orders_id) from  orders ");
    $stmt->execute();
    $maxid = $stmt->fetchColumn(); // fetch max
    $data =array( "cart_orders"=>$maxid);
    updateData("cart", $data, "cart_usersid = $usersid AND cart_orders = 0");

    
    






}
