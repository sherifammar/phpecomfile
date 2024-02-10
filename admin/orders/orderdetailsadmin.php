<?php
include "../../connect.php";

$ordersid= filterRequest("ordersid");
getAllData("ordersdetailview","cart_orders = '$ordersid'");
// main all order  is done 