<?php
include"../../connect.php";
$email= filterRequest("email");// email add in field of thunder client
$verfiy= filterRequest("verfiycode"); // email add in veriycode of thunder client
       
$stmt = $con->prepare("SELECT * FROM admin WHERE admin_email ='$email' AND admin_verfiycode='$verfiy'" );
$stmt ->execute();
$count = $stmt->rowCount();// check on verfiycode and email of client then update 
result($count);