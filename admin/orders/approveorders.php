<?php
include "../../connect.php";

$ordersid= filterRequest("ordersid");
$usersid= filterRequest("usersid");
$data = array("orders_status"=> 1);
updateData("orders", $data, "orders_id = $ordersid AND orders_status = 0");
insertNotification("sucess ","order is approve",$usersid,"users$usersid", "none", "orderspending"); // save and send notification

//================================================
// sendGCM("sucess ", "order is approve", "users$usersid", "none", "orderspending"); //  for testing only ===if send only notification with out save table

