<?php
include "../connect.php";

$usersid= filterRequest("usersid");
getAllData("ordersview","orders_usersid = '$usersid' AND orders_status !=4 ");

//=========
// wait -> 0
//  prepare ->1
//  delivery man->2 
// on run -> 3
//  archive ->4