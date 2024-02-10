

<?php
include '../connect.php';


$ordersid= filterRequest("ordersid");

deleteData("orders", "orders_id = $ordersid AND orders_status = 0 ");
// must be orders status =0