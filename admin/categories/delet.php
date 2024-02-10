<?php
include "../../connect.php";
$categoriesid= filterRequest("categoriesid");
$imagename= filterRequest("imagename");

deleteFile("../../upload/cats", $imagename);

deleteData("categories", "categories_id = $categoriesid");
