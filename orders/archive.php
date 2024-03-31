<?php
include "../connect.php";

$usersid= filterRequest("usersid");
// getAllData("ordersview","orders_usersid = '$usersid' AND orders_status = 4 ");
// getAllData("ordersdetailsadmin","1=1 AND orders_status = 4 AND cart_usersid = '$usersid'"); // solve problem of wael inthe end view

// getAllData("ordersdetailsadmin","cart_usersid = '$usersid'"); // // solve problem of wael inthe end view

getAllData("orders","orders_usersid = '$usersid'"); // تم تغير اصلاح archive  تم التغير orderdetailadmin  to orders table
//=========
// wait -> 0
//  prepare ->1
//  delivery man->2 
// on run -> 3
//  archive ->4