<?php
include "../../connect.php";

$itemsid = filterRequest("itemsid");
$itemsname= filterRequest("itemsname");
$itemsnamear= filterRequest("itemsnamear");
$itemsdesc = filterRequest("itemsdesc");
$itemsdecsar = filterRequest("itemsdecsar");
$itemscount = filterRequest("itemscount");
$itemsactive = filterRequest("itemsactive");
$itemsprice = filterRequest("itemsprice");
$itemsdiscount = filterRequest("itemsdiscount");
$itemscat  = filterRequest("itemscat");
$res =imageUpload("../../upload/items","files");
$now= date("Y-m-d h:i:s"); // able to delet
$imageold = filterRequest("imageold");

//=================
// $now= filterRequest("datetime");
// ====================

if ($res =="Empty") {
    $data = array(
    "items_name"=>$itemsname,// nanme colum in musql == var username
    "items_name_ar"=>$itemsnamear,
    "items_desc" =>$itemsdesc,
    "items_decs_ar"=>$itemsdecsar,
    "items_count"=>$itemscount,
    "items_active"=>$itemsactive,
    "items_price"=>$itemsprice,
    "items_discount"=>$itemsdiscount,
    "items_date"=>$now,
    "items_cat"=>$itemscat,
    
    
        );

} else {
    deleteFile("../../upload/items", $imageold);
    $data = array(
       
    "items_name"=>$itemsname,// nanme colum in musql == var username
    "items_name_ar"=>$itemsnamear,
    "items_desc"=>$itemsdesc,
    "items_decs_ar"=>$itemsdecsar,
    "items_image"=>$res,
    "items_count"=>$itemscount,
    "items_active"=>$itemsactive,
    "items_price"=>$itemsprice,
    "items_discount"=>$itemsdiscount,
    "items_date"=>$now,
   "items_cat"=>$itemscat,
    
        );
}

updateData("items", $data,"items_id=$itemsid");