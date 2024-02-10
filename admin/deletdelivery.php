<?php
include "../connect.php";
$deliveryid= filterRequest("deliveryid");


deleteData("delivery", "delivery_id = $deliveryid");