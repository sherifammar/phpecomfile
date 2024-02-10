<?php
include"../connect.php";

$usersid= filterRequest("usersid");
 $data = getAllData("cartview","cart_usersid = $usersid", null ,false);

 
$stmt = $con->prepare("SELECT SUM(cartview.itemsprice) AS totalprice , SUM(cartview.countitems) AS totalitems , COUNT(cartview.countitems) AS differentitems FROM cartview WHERE cartview.cart_usersid = '$usersid'  GROUP BY cartview.cart_usersid");

 $stmt->execute();

 $dataprice = $stmt->fetch(PDO::FETCH_ASSOC);
    
        echo json_encode(array("status" => "success", 
        "data" => $data,
        "dataprice"=>$dataprice));
  
// ==== two reguest $data , $dataprice

