<?php

include '../connect.php';// error solved =>../ connect.php

// include 'connect.php';

$categoriesid = filterRequest("id"); // id of catogeries
// id from flutter page

//////////////////////////////////////////////////////////////////////////////////

//  getAllData("items1view",'1=1' );// for test to fetch all items(1=1)main aii items

//  getAllData("items1view","categories_id = '$categoriesid'");

////////////////////////////////////////////////////


$userid= filterRequest("userid");
 $stmt = $con->prepare("SELECT items1view.* , 1 as favorite , (items_price -(items_price * items_discount/100)) AS itempricediscount FROM items1view INNER JOIN favorite ON  favorite.favorite_itemsid = items1view.items_id AND favorite.favorite_usersid = $userid 
 WHERE categories_id = $categoriesid
 UNION ALL 
 SELECT *,0 as favorite , (items_price -(items_price * items_discount/100)) AS itempricediscount  FROM items1view 
 WHERE  categories_id = $categoriesid AND items_id NOT IN (SELECT items1view.items_id FROM items1view INNER JOIN favorite ON items1view.items_id= favorite.favorite_itemsid AND favorite.favorite_usersid = $userid)");
 
 $stmt->execute();

 $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();
    if ($count>0) {
        echo json_encode(array("status" => "success", "data" => $data));
    }
    else{
        echo json_encode(array("status" => "failure"));
    }


