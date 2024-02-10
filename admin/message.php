<?php
include"../connect.php";
$title= filterRequest("title");
$body= filterRequest("body");
$usersid= filterRequest("usersid");
$top= filterRequest("top");

if($usersid == "0")
{

    insertNotification("$title","$body",$usersid,"$top", "none", "none");

}
else {
   
    insertNotification("$title","$body",$usersid,"$top.$usersid", "none", "none"); }// save and send notification


 