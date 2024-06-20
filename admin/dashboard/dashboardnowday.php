<?php

include '../../connect.php';

$days= date("d");
$mounths=date("m");
$years=date("Y");

    $stmt = $con->prepare("SELECT 
    SUM(ordersdeliverydetailsadmin.orders_totalprice) AS totalitemsprice, 
COUNT(ordersdeliverydetailsadmin.id) AS totalnumberorders, 
SUM(ordersdeliverydetailsadmin.countitems) AS totalcountitems , 
SUM(ordersdeliverydetailsadmin.orders_pricedelivery) AS totalpricedelivery ,
SUM(ordersdeliverydetailsadmin.orders_coupon) AS totaldiscountcoupon,
SUM(ordersdeliverydetailsadmin.items_discount) AS totaldiscount 


FROM ordersdeliverydetailsadmin  Where ordersdeliverydetailsadmin.day = '$days' AND ordersdeliverydetailsadmin.mounth = '$mounths' AND ordersdeliverydetailsadmin.year = '$years'"
);
   
    
  
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $count  = $stmt->rowCount();
        if ($count>0) {
            echo json_encode(array("status" => "success", "data" => $data));
        }
        else{
            echo json_encode(array("status" => "failure"));
        }