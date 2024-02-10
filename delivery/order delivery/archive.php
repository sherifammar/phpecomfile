<?php
include "../../connect.php";
$deliveryid=filterRequest("deliveryid");
// getAllData("orders","1= 1 AND orders_status = 4 AND orders_delivery = $deliveryid ");
getAllData("ordersview","1= 1 AND orders_status = 4 AND orders_delivery = $deliveryid ");