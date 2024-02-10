<?php
include "../../connect.php";
$itemsname= filterRequest("itemsname");
$itemsnamear= filterRequest("itemsnamear");
$itemsdesc = filterRequest("itemsdesc");
$itemsdecsar = filterRequest("itemsdecsar");
$itemscount = filterRequest("itemscount");
// $itemsactive = filterRequest("itemsactive");
$itemsprice = filterRequest("itemsprice");
$itemsdiscount = filterRequest("itemsdiscount");
$itemscat= filterRequest("itemscat");





$itemsimage=imageUpload("../../upload/items" ,"files");
$now= date("Y-m-d h:i:s"); // able to delet

//=================
// $now= filterRequest("datetime");
// ====================
$data = array(
"items_name"=>$itemsname,// nanme colum in musql == var username
"items_name_ar"=>$itemsnamear,
"items_desc"=>$itemsdesc,
"items_decs_ar"=>$itemsdecsar,
"items_image"=>$itemsimage,
"items_count"=>$itemscount,
"items_active"=>"1",
"items_price"=>$itemsprice,
"items_discount"=>$itemsdiscount,
"items_date"=>$now,
"items_cat"=>$itemscat,

    );
    insertData('items', $data);