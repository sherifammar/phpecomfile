<?php
include "../connect.php";


// $now= date("Y-m-d h:i:s"); // error => it is time now

// $couponname= filterRequest("couponname");



//  getData("coupon","coupon_name = '$couponname' AND coupon_expiredate > '$now' AND coupon_count > 0");
//=========================test=====================

//  getData("coupon","coupon_name = '$couponname' "); // for testing 

// ============ more cuurent ======

// $couponcount= filterRequest("couponcount");
// getData("coupon","coupon_name = '$couponname' AND coupon_expiredate > '$now' AND coupon_count = '$couponcount'");

//======================= now version ==
$now= date("Y-m-d h:i:s"); // error => it is time now

$couponname= filterRequest("couponname");

$usersid= filterRequest("usersid");

$checkcouponrecorder = getData("couponrecorder","couponrecorder_couponname = '$couponname' AND 	couponrecorder_usersid ='$usersid'" ,null ,false);
if($checkcouponrecorder>0) {
    echo json_encode(array("status" => "failure"));
}else{
    getData("coupon","coupon_name = '$couponname' AND coupon_expiredate > '$now' AND coupon_count > 0 ");
}