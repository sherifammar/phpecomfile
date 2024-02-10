<?php
include"../../connect.php";
$email= filterRequest("email");// email add in field of thunder client
$verfiy= filterRequest("verfiycode"); // email add in veriycode of thunder client
       
$stmt = $con->prepare("SELECT * FROM delivery WHERE delivery_email ='$email' AND delivery_verfiycode='$verfiy'" );
$stmt ->execute();
$count = $stmt->rowCount();// check on verfiycode and email of client then update 
if ($count >0) {
   
    $data = array(
        "delivery_approve"=>"1"); 
        // "users_approve"=>name of colum users table

        //  sendEmail($email,"verfiy code","verfiy code : $verfiycode"); // send email to admin for approved
        updateData("delivery",$data,"delivery_email ='$email'" ); // update where "users_email ='$email'" of client
}else {
    printFailure($message="error in verfiycode") ; 
       
   
}