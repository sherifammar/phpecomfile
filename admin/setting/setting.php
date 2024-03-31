<?php
include "../../connect.php";
 

 $settingtitle=filterRequest("settingtitle");
 $settingbody = filterRequest("settingbody");
 $settingdeliverytime = filterRequest("settingdeliverytime");
 $settingstartlat = filterRequest("settingstartlat");
 $settinglong = filterRequest("settinglong");
 $settingspeed = filterRequest("settingspeed");
 $settingpricepekilo = filterRequest("settingpricepekilo");
 $now= date("Y-m-d h:i:s");



 $data= array(
    "setting_title" =>$settingtitle,
    "setting_body" =>$settingbody,
 "setting_deliverytime"=>$settingdeliverytime,
 "setting_startlat" =>$settingstartlat,
 "setting_long" =>$settinglong,	
 "setting_speed" =>$settingspeed,
 "setting_pricepekilo" =>$settingpricepekilo,
 "setting_createtime"=> $now
);// rror=>solve ;;;
insertData("setting", $data);