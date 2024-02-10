<?php
include "../../connect.php";

$ordersid= filterRequest("ordersid");
$usersid= filterRequest("usersid");
$data = array("orders_status"=> 4);
updateData("orders", $data, "orders_id = $ordersid AND orders_status = 3");
insertNotification("sucess ","your order has been delivery ..thank you",$usersid,"users$usersid", "none", "orderspending"); // save and send notification and send to user
sendGCM("Alert", "the order has been  deliver to custome ", "admin", "none", "none");// send to admin

  // ================ solved point of wael of  end video
 $s= $con->prepare("Insert Into ordersdetailsadmin 
 (itemsprice,
 countitems,
 cart_id ,
 cart_usersid,
     cart_itemsid,
     cart_orders,
     items_id,
 items_name,
     items_name_ar,
     items_desc,
     items_decs_ar,
         items_image,
         items_count,
         items_active,
         items_price,
         items_discount,
         items_date,
         items_cat
         )
 Select itemsprice,
 countitems,
 cart_id ,
 cart_usersid,
     cart_itemsid,
     cart_orders,
     items_id,
 items_name,
     items_name_ar,
     items_desc,
     items_decs_ar,
         items_image,
         items_count,
         items_active,
         items_price,
         items_discount,
         items_date,
         items_cat
 From ordersdetailview WHERE ordersdetailview.cart_orders = '$ordersid'");
 $s->execute();
 $data2=array(
    "day"=> date("d"),
    "mounth"=> date("m"),
    "year"=> date("y")

);
updateData("ordersdetailsadmin ", $data2, "ordersdetailsadmin.cart_orders = $ordersid");