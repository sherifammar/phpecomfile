<?php

include '../connect.php';

$searchmounth1= filterRequest("searchmounth1");
$searchmounth2= filterRequest("searchmounth2");
$searchyear1= filterRequest("searchyear1");
$searchyear2= filterRequest("searchyear2");

if ($searchmounth1 =="" && $searchmounth2 =="" && $searchyear1 =="" && $searchyear2=="") { // error solved =>==


    $stmt = $con->prepare("SELECT ordersdeliverydetailsadmin.day, ordersdeliverydetailsadmin.mounth,ordersdeliverydetailsadmin.year,
    SUM(ordersdeliverydetailsadmin.orders_totalprice) AS totalitemsprice,
    COUNT(ordersdeliverydetailsadmin.id) AS totalnumberorders, 
    SUM(ordersdeliverydetailsadmin.countitems) AS totalcountitems ,
     SUM(ordersdeliverydetailsadmin.orders_pricedelivery) AS totalpricedelivery , 
     SUM(ordersdeliverydetailsadmin.orders_coupon) AS totaldiscountcoupon, AVG(ordersdeliverydetailsadmin.items_discount) AS totaldiscount
     FROM ordersdeliverydetailsadmin WHERE ordersdeliverydetailsadmin.year BETWEEN '$searchyear1' AND '$searchyear2' AND ordersdeliverydetailsadmin.mounth BETWEEN '$searchmounth1' AND '$searchmounth2'
    GROUP BY ordersdeliverydetailsadmin.day ,ordersdeliverydetailsadmin.mounth , ordersdeliverydetailsadmin.year");
    $stmt->execute();
    
     $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $count  = $stmt->rowCount();
        if ($count>0) {
            echo json_encode(array("status" => "success", "data" => $data));
        }
        else{
            echo json_encode(array("status" => "failure"));
        }
}else {
    $stmt = $con->prepare("SELECT ordersdeliverydetailsadmin.day, ordersdeliverydetailsadmin.mounth,ordersdeliverydetailsadmin.year,
    SUM(ordersdeliverydetailsadmin.orders_totalprice) AS totalitemsprice,
    COUNT(ordersdeliverydetailsadmin.id) AS totalnumberorders, 
    SUM(ordersdeliverydetailsadmin.countitems) AS totalcountitems ,
     SUM(ordersdeliverydetailsadmin.orders_pricedelivery) AS totalpricedelivery , 
     SUM(ordersdeliverydetailsadmin.orders_coupon) AS totaldiscountcoupon, AVG(ordersdeliverydetailsadmin.items_discount) AS totaldiscount
     FROM ordersdeliverydetailsadmin WHERE  ordersdeliverydetailsadmin.year BETWEEN '$searchyear1' AND '$searchyear2' AND ordersdeliverydetailsadmin.mounth BETWEEN '$searchmounth1' AND '$searchmounth2'
    GROUP BY ordersdeliverydetailsadmin.day ,ordersdeliverydetailsadmin.mounth , ordersdeliverydetailsadmin.year");
    $stmt->execute();
    
     $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $count  = $stmt->rowCount();
        if ($count>0) {
            echo json_encode(array("status" => "success", "data" => $data));
        }
        else{
            echo json_encode(array("status" => "failure"));
        }
}






