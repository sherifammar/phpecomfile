<?php
include"../connect.php";
 $username= filterRequest("username");// username from textform flutter
 $password= sha1($_POST['password']);
 $email= filterRequest("email");
 $phone= filterRequest("phone");
 $verfiycode=01010;

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
        "users_verfiycode"=>$verfiycode,
    "users_approve"=>1);
        
  
    insertData('users',$data);// insert new customer in table
     
 }