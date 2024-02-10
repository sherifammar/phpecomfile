<?php

include '../connect.php';
$search= filterRequest("search");
// getAllData("items1view", "items_name LIKE '%$search%' OR items_name_ar LIKE '%$search%' ");

//======================================== fetch discount in search  ===

$stmt = $con->prepare("
SELECT  items1view.* , 1 as favorite, (items_price -(items_price * items_discount/100)) AS itempricediscount  FROM items1view 
WHERE items_name LIKE '%$search%' OR items_name_ar LIKE '%$search%' ");
$stmt->execute();

 $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();
    if ($count>0) {
        echo json_encode(array("status" => "success", "data" => $data));
    }
    else{
        echo json_encode(array("status" => "failure"));
    }
    // ============== search for all not favorite
//     SELECT  items1view.* ,  (items_price -(items_price * items_discount/100)) AS itempricediscount  FROM items1view 
// WHERE items_name LIKE '%$search%' OR items_name_ar LIKE '%$search%' ");