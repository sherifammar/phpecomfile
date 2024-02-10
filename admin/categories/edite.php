<?php
include "../../connect.php";

$categoriesid= filterRequest("categoriesid");

$categoriesname= filterRequest("categoriesname");
$categoriesnamear= filterRequest("categoriesnamear");
 $res =imageUpload("../../upload/cats","files");
$now= date("Y-m-d h:i:s"); // able to delet
$imageold = filterRequest("imageold");

//=================
// $now= filterRequest("datetime");
// ====================

if ($res =="Empty") {
    $data = array(
        "categories_name"=>$categoriesname,// nanme colum in musql == var username
        "categories_name_ar"=>$categoriesnamear,
     
        "categories_datetime"=>$now,
        );
} else {
    deleteFile("../../upload/cats", $imageold);
    $data = array(
       
        "categories_name"=>$categoriesname,// nanme colum in musql == var username
        "categories_name_ar"=>$categoriesnamear,
        "categories_image"=>$res,
        "categories_datetime"=>$now,
        );
}


    updateData("categories", $data,"categories_id = $categoriesid");