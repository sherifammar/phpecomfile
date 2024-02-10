<?php
include"../../connect.php";
 $username= filterRequest("username");// username from textform flutter
 $password= sha1($_POST['password']);
 $email= filterRequest("email");
 $phone= filterRequest("phone");
 $verfiycode= rand(10000,99999);

 $stmt = $con->prepare('SELECT * FROM admin WHERE admin_email =? or admin_phone=?' );
 $stmt ->execute(array($email,$phone));
 $count = $stmt->rowCount();
 if ($count >0) {
    printFailure("phone or email exist");
 }else {// count == 0 then creat new client by insert method
    $data = array(
        "admin_name"=>$username,// nanme colum in musql == var username
        "admin_password"=>$password,
        "admin_email"=>$email,
        "admin_phone"=>$phone,
        "admin_verfiycode"=>$verfiycode,);
        
   //  sendEmail($email,"verfiy code","verfiy code : $verfiycode"); 
   // send email with verfiycode to client
    insertData('admin',$data);// insert new customer in table
     
 }