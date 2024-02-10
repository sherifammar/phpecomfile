<?php
include '../connect.php';

$usersid= filterRequest("usersid");
$itemsid= filterRequest("itemsid");

deleteData("cart", "cart_id = (SELECT cart_id FROM cart WHERE cart_usersid= $usersid AND cart_itemsid = $itemsid AND cart_orders = 0  LIMIT 1)  ");


$stmt= $con ->prepare("SELECT  `items_count` FROM `items` WHERE `items`.`items_id` = '$itemsid'");

$stmt->execute();

 $dec = $stmt->fetchColumn();
 $dec =$dec+ 1;
 $stmt=$con->prepare("UPDATE `items` SET `items_count`= $dec WHERE `items`.`items_id` = '$itemsid'");
    $stmt->execute();
// can remove one item only


// /////////////////////////////////////////////


// <?php
// include '../connect.php';

// $usersid= filterRequest("usersid");
// $itemsid= filterRequest("itemsid");

// deleteData("cart", "cart_usersid= $usersid AND cart_itemsid = $itemsid AND cart_orders = 0");

// // can remove all item only


// // 

