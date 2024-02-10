<?php

include "../connect.php";
$itemsid= filterRequest("itemsid");
getAllData("ratingitems","ratingitems_itemsid = ?", array($itemsid));