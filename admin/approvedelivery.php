<?php
include"../connect.php";
 
 $deliveryid= filterRequest("deliveryid");

 
$data=array(
"delivery_approve" =>"1"
);

 updateData("delivery",$data, "delivery_id = '$deliveryid'");