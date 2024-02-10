<?php
include "../connect.php";


$now= date("Y-m-d h:i:s"); // error => it is time now

$couponname= filterRequest("couponname");



 getData("coupon","coupon_name = '$couponname' AND coupon_expiredate > '$now' AND coupon_count > 0");

//  getData("coupon","coupon_name = '$couponname' "); // for testing 

// ============ more cuurent ======

// $couponcount= filterRequest("couponcount");
// getData("coupon","coupon_name = '$couponname' AND coupon_expiredate > '$now' AND coupon_count = '$couponcount'");
