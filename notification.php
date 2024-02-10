<?php

include './connect.php';// error solved =>../ connect.php

// include 'connect.php';

$usersid = filterRequest("usersid");
// getAllData("notification","notification_usersid = $usersid");

// ================ fetch all detail (sherif test) =====
getAllData("notificationordersdetailview","notification_usersid = $usersid");