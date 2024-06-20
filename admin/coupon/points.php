<?php
include "../../connect.php";



$pointsdiscount= filterRequest("pointsdiscount");
$pointsexpiredate = filterRequest("pointsexpiredate") ;
$pointsowneritemsid = filterRequest("pointsowneritemsid") ;
$pointsscore = filterRequest("pointsscore") ;

//=================
// $now= filterRequest("datetime");
// ====================


    $data = array(
        
        "points_discount"=>$pointsdiscount,
        "points_expiredate"=> $pointsexpiredate, 
    "points_owner_items_id"=>$pointsowneritemsid  ,
    "points_score"=>$pointsscore
 
        );



        updateData("points", $data,"points_owner_items_id = $pointsowneritemsid");