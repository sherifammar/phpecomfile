<?php
include"../../connect.php";
$email= filterRequest("email");// email add in field of thunder client
$verfiy= filterRequest("verfiycode"); // email add in veriycode of thunder client
       
$stmt = $con->prepare("SELECT * FROM delivery WHERE delivery_email ='$email' AND delivery_verfiycode='$verfiy'" );
$stmt ->execute();
$count = $stmt->rowCount();// check on verfiycode and email of client then update 
result($count);