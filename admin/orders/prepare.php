<?php
include "../../connect.php";

$ordersid= filterRequest("ordersid");
$usersid= filterRequest("usersid");
$type= filterRequest("orderstype");

if($type == "0")
{$data = array("orders_status"=> 2);
    updateData("orders", $data, "orders_id = $ordersid AND orders_status = 1"); 

}
else {
    $data = array("orders_status"=> 4);// main recive
    updateData("orders", $data, "orders_id = $ordersid AND orders_status = 1");
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
}

$data2=array(
    "day"=> date("d"),
    "mounth"=> date("m"),
    "year"=> date("y")

);
updateData("ordersdetailsadmin ", $data2, "ordersdetailsadmin.cart_orders = $ordersid");
// updateData("orders", $data, "orders_id = $ordersid AND orders_status = 1");// convert to delivery prepare to delivery
insertNotification("sucess ","order is prepare",$usersid,"users$usersid", "none", "orderspending"); // save and send notification


if($type == "0")
{sendGCM("Alert", "order is await for approve by delivery", "delivery", "none", "none"); } // send to delivery


