<?php 

include './connect.php';
// $table = "users";
// // $name = filterRequest("namerequest");
// $data = array( 
// "users_name" => "wael",
// "users_email" => "wael@gmail.com",
// "users_phone" => "324234",
// "users_verfiycode" => "3243243",       
// );
// $count = insertData($table , $data);
// $to =

// //  sendEmail("sherifammar30@gmail.com","hi sherif","send email to sherif");
// // getAllData("users", "1=1");

// $to="sherifammar30@gmail.com";
// $title= "hi";
// $message= " body";
// $header= "php test"
// mail
// mail($to,$title,$message,$header);

// ==================================
// imageUpload("file");// file => will added in test

// ===============================

$notAuth="";
$usersid= filterRequest("usersid");
sendGCM("hi", "how are you", "users", "users$usersid","none", "none");
echo "send";

?>
