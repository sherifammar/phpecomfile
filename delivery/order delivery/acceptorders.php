<?php
include "../../connect.php";
$deliveryid=filterRequest("deliveryid");
getAllData("ordersview","1= 1 AND orders_status = 3 AND orders_delivery = $deliveryid ");// orders_delivery = $deliveryid is id of del