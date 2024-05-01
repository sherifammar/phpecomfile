<?php

include '../../connect.php';
$years= date("Y");

//============== mounth
$stmt = $con->prepare("SELECT SUM(ordersdeliverydetailsadmin.orders_totalprice) AS totalitemsprice, COUNT(ordersdeliverydetailsadmin.id) AS totalnumberorders, SUM(ordersdeliverydetailsadmin.countitems) AS totalcountitems , SUM(ordersdeliverydetailsadmin.orders_pricedelivery) AS totalpricedelivery , SUM(ordersdeliverydetailsadmin.orders_coupon) AS totaldiscountcoupon, SUM(ordersdeliverydetailsadmin.items_discount) AS totaldiscount ,MONTHNAME(ordersdeliverydetailsadmin.orders_date) AS mounth_name FROM ordersdeliverydetailsadmin WHERE ordersdeliverydetailsadmin.year =  '$years' GROUP BY MONTHNAME(ordersdeliverydetailsadmin.orders_date) ORDER BY mounth_name ;
"
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


        //========================
//         <?php

// include '../../connect.php';


// //============== mounth
// $stmt = $con->prepare("SELECT SUM(ordersdeliverydetailsadmin.orders_totalprice) AS totalitemsprice, COUNT(ordersdeliverydetailsadmin.id) AS totalnumberorders, SUM(ordersdeliverydetailsadmin.countitems) AS totalcountitems , SUM(ordersdeliverydetailsadmin.orders_pricedelivery) AS totalpricedelivery , SUM(ordersdeliverydetailsadmin.orders_coupon) AS totaldiscountcoupon, SUM(ordersdeliverydetailsadmin.items_discount) AS totaldiscount ,MONTHNAME(ordersdeliverydetailsadmin.orders_date) AS mounth_name FROM ordersdeliverydetailsadmin  GROUP BY MONTHNAME(ordersdeliverydetailsadmin.orders_date) ORDER BY mounth_name ;
// "
// );

 
    
  
//     $stmt->execute();
//     $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
//         $count  = $stmt->rowCount();
//         if ($count>0) {
//             echo json_encode(array("status" => "success", "data" => $data));
//         }
//         else{
//             echo json_encode(array("status" => "failure"));
//         }