<?php


include "../../connect.php";


$checkcountitem = getData("items","items_count <= items_active" ,null ,false);

if($checkcountitem >0){
    sendGCM("Alert", "items is less", "admin", "none", "none");
   
   
}
 // ===============