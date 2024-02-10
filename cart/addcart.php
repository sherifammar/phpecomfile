<?php

include '../connect.php';

$usersid= filterRequest("usersid");
$itemsid= filterRequest("itemsid");
$count= getData("cart","cart_usersid=$usersid AND cart_itemsid = $itemsid AND cart_orders = 0", null ,false);


    $data= array(
        "cart_usersid" =>$usersid ,
        "cart_itemsid" =>$itemsid);

    insertData("cart", $data);

    $stmt= $con ->prepare("SELECT  `items_count` FROM `items` WHERE `items`.`items_id` = '$itemsid'");

$stmt->execute();

 $dec = $stmt->fetchColumn();
 $dec =$dec- 1;
 $stmt=$con->prepare("UPDATE `items` SET `items_count`= $dec WHERE `items`.`items_id` = '$itemsid'");
    $stmt->execute();
