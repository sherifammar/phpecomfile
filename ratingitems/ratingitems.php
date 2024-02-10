<?php

include "../connect.php";
$usersid= filterRequest("usersid");
$usersname= filterRequest("usersname");
$itemsid= filterRequest("itemsid");
$ratingitemsrate = filterRequest("ratingitemsrate");
$ratingitemscomment = filterRequest("ratingitemscomment");
$now= date("Y-m-d h:i:s");
$data = array(
    "ratingitems_usersid" =>$usersid,
    "ratingitems_usersname" =>$usersname,
    "ratingitems_itemsid" =>$itemsid,
    "ratingitems_rate" =>$ratingitemsrate,
    "ratingitems_comment" =>$ratingitemscomment,
    "ratingitems_time" =>$now,
);

insertData("ratingitems",$data);



