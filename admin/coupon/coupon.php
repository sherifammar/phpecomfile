<?php
include "../../connect.php";

$couponname= filterRequest("couponname");
$couponcount= filterRequest("couponcount");
$coupondiscount= filterRequest("coupondiscount");
$couponexpiredate = filterRequest("couponexpiredate") ;
// $couponid = filterRequest("couponid") ;


//=================
// $now= filterRequest("datetime");
// ====================


    $data = array(
        "coupon_name"=>$couponname,// nanme colum in musql == var username
        "coupon_count"=>$couponcount, "coupon_discount"=>$coupondiscount,
        "coupon_discount"=>$coupondiscount,
        "coupon_expiredate"=> $couponexpiredate, 
   
 
        );

        

    updateData("coupon", $data,"coupon_id = 1");