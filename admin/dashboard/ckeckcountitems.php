<?php


include "../../connect.php";

 
 $stmt = $con->prepare("SELECT  * FROM items WHERE items_count <= items_active ");


$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count  = $stmt->rowCount();

    if ($count > 0){
        sendGCM("Alert", "items is less", "admin", "none", "none");
        echo json_encode(array("status" => "success", "data" => $data));
        
    } else {
        echo json_encode(array("status" => "failure"));
    }