<?php

// include './connect.php';

include 'connect.php';
$alldata =array();
$alldata['status']="success";// print scucee 

$setting = getAllData("setting",null , null , false); // flase can not print scucess

$alldata['setting']= $setting;

$categories = getAllData("categories",null , null , false); // flase can not print scucess

$alldata['categories']= $categories;// $alldata is array
// ====================================
// $items = getAllData("items1view","items_discount !=0" , null , false); // fetch all item without discount
//  ============================================
$items = getAllData("itemstopselling","1 =1 ORDER BY countitems DESC" , null , false);// fetch all data
$alldata['items']= $items;
 
echo json_encode($alldata);