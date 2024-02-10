<?php
include"../connect.php";
 $username= filterRequest("username");// username from textform flutter
 $password= sha1($_POST['password']);
 $email= filterRequest("email");
 $phone= filterRequest("phone");
 $verfiycode= rand(10000,99999);

 $stmt = $con->prepare('SELECT * FROM users WHERE users_email =? or users_phone=?' );
 $stmt ->execute(array($email,$phone));
 $count = $stmt->rowCount();
 if ($count >0) {
    printFailure("phone or email exist");
 }else {// count == 0 then creat new client by insert method
    $data = array(
        "users_name"=>$username,// nanme colum in musql == var username
        "users_password"=>$password,
        "users_email"=>$email,
        "users_phone"=>$phone,
        "users_verfiycode"=>$verfiycode,);
        
   //  sendEmail($email,"verfiy code","verfiy code : $verfiycode"); 
   // send email with verfiycode to client
    insertData('users',$data);// insert new customer in table
     
 }