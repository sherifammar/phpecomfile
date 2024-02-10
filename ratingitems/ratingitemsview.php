<?php

include "../connect.php";
$itemsid= filterRequest("itemsid");
getAllData("ratingitemsview","ratingitems_itemsid = ?", array($itemsid));

