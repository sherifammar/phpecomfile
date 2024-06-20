<?php
include "../../connect.php";
// getAllData("categories");
$pointsowneradminid= filterRequest("pointsowneradminid");

getAllData("points","points_owner_items_id  = '$pointsowneradminid'");