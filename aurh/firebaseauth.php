<?php
include"../connect.php";
$email= filterRequest("email");// email add in field of thunder client

   
    $data = array(
        "users_approve"=>"1"); 
        // "users_approve"=>name of colum users table

        //  sendEmail($email,"verfiy code","verfiy code : $verfiycode"); // send email to admin for approved
        updateData("users",$data,"users_email ='$email'" ); // update where "users_email ='$email'" of client --> -->
