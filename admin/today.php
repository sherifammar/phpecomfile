<?php

include '../connect.php';
$searchday= date("d");
$searchmounth= date("m");
$searchyear= date("Y");


    $stmt = $con->prepare("SELECT SUM(ordersdeliverydetailsadmin.itemsprice) AS totalitemsprice, 
    COUNT(ordersdeliverydetailsadmin.id) AS totalnumberorders, 
    SUM(ordersdeliverydetailsadmin.countitems) AS totalcountitems , 
    SUM(ordersdeliverydetailsadmin.orders_pricedelivery) AS totalpricedelivery ,ordersdeliverydetailsadmin.day,ordersdeliverydetailsadmin.mounth,ordersdeliverydetailsadmin.year
    FROM ordersdeliverydetailsadmin WHERE ordersdeliverydetailsadmin.day ='$searchday' AND ordersdeliverydetailsadmin.mounth ='$searchmounth' AND ordersdeliverydetailsadmin.year ='$searchyear'"
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

  

