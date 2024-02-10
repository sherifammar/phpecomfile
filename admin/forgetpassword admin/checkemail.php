<?php
include"../../connect.php";
 

 $email= filterRequest("email");
 $verfiycode= rand(10000,99999);

 $stmt = $con->prepare('SELECT * FROM admin WHERE admin_email =? ' );
 $stmt ->execute(array($email));
 $count = $stmt->rowCount();
 result($count);
 if ($count>0) {
   $data =array("admin_verfiycode"=>$verfiycode);
   updateData("admin",$data , "admin_email='$email'" ,false);//  it can not print 2 success
  //  sendEmail($email,"verfiy code ecommerce","verfiycode $verfiycode");

 }