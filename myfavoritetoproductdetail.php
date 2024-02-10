<?php

include "./connect.php";
$itemsid= filterRequest("itemsid");
getAllData("items1view","items_id = ?", array($itemsid));