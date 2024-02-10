<?php
include"../connect.php";
 
 $usersid= filterRequest("usersid");

 
$data=array(
"users_approve" =>"1"
);

 updateData("users",$data, "users_id = '$usersid'");