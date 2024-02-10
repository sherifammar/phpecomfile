<?php
include "../../connect.php";
$categoriesname= filterRequest("categoriesname");
$categoriesnamear= filterRequest("categoriesnamear");
$categoriesimage=imageUpload("../../upload/cats" ,"files");
$now= date("Y-m-d h:i:s"); // able to delet

//=================
// $now= filterRequest("datetime");
// ====================

$data = array(
    "categories_name"=>$categoriesname,// nanme colum in musql == var username
    "categories_name_ar"=>$categoriesnamear,
    "categories_image"=>$categoriesimage,
    "categories_datetime"=>$now,
    );
    

insertData('categories',$data);