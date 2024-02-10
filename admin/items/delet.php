<?php
include "../../connect.php";
$itemsid= filterRequest("itemsid");
$imagename= filterRequest("imagename");

deleteFile("../../upload/items", $imagename);

deleteData("items", "items_id = $itemsid");