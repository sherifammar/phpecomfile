<?php
include "../connect.php";

$usersid= filterRequest("usersid");
// getAllData("ordersview","orders_usersid = '$usersid' AND orders_status = 4 ");
getAllData("ordersdetailsadmin","1=1 AND orders_status = 4 AND orders_usersid = '$usersid'"); // solve problem of wael inthe end view


//=========
// wait -> 0
//  prepare ->1
//  delivery man->2 
// on run -> 3
//  archive ->4