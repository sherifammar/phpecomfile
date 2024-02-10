<?php
include "../../connect.php";

$ordersid= filterRequest("ordersid");
$usersid= filterRequest("usersid");
$deliveryid=filterRequest("deliveryid");
$data = array("orders_status"=> 3,
"orders_delivery" => $deliveryid);
updateData("orders", $data, "orders_id = $ordersid AND orders_status = 2");
insertNotification("sucess ","your order is on the  way ",$usersid,"users$usersid", "none", "orderspending"); // save and send notification
sendGCM("Alert", "order is approved by delivery ", "admin", "none", "none");// send to admin = service
sendGCM("Alert", "the order has approved by delivery and his number : =>" . $deliveryid, "delivery", "none", "none");// send to another delivery boy
//================================================
// sendGCM("sucess ", "order is approve", "users$usersid", "none", "orderspending"); //  for testing only ===if send only notification with out save table
// orders_delivery" link between order table and delivery table
