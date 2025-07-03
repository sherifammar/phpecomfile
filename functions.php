<?php



define("MB", 1048576);

function filterRequest($requestname)
{
  return  htmlspecialchars(strip_tags($_POST[$requestname]));
}

function getAllData($table, $where = null, $values = null, $json=true)//json = true if u need print success
{
    global $con;
    $data = array();
    if ($where== null) {
        $stmt = $con->prepare("SELECT  * FROM $table  ");
    } else {
        $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");
    }
    
    $stmt->execute($values);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "failure"));
        }
        return $count;
    }else {// main false return data to $data
       if ($count > 0) {
        return $data;
       

       } else {
        return json_encode(array("status" => "failure"));
       }
       
    }
  
}

function getData($table, $where = null, $values = null,$json=true)
{
    global $con;
    $data = array();
    $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");
    $stmt->execute($values);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();

    
    if ($json == true) {
        if ($count > 0){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "failure"));
        }} else {
        return $count;
        
        // main false return data to $data

    
}}




function insertData($table, $data, $json = true)
{
    global $con;
    foreach ($data as $field => $v)
        $ins[] = ':' . $field;
    $ins = implode(',', $ins);
    $fields = implode(',', array_keys($data));
    $sql = "INSERT INTO $table ($fields) VALUES ($ins)";

    $stmt = $con->prepare($sql);
    foreach ($data as $f => $v) {
        $stmt->bindValue(':' . $f, $v);
    }
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($json == true) {
    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "failure"));
    }
  }
    return $count;
}


function updateData($table, $data, $where, $json = true)
{
    global $con;
    $cols = array();
    $vals = array();

    foreach ($data as $key => $val) {
        $vals[] = "$val";
        $cols[] = "`$key` =  ? ";
    }
    $sql = "UPDATE $table SET " . implode(', ', $cols) . " WHERE $where";

    $stmt = $con->prepare($sql);
    $stmt->execute($vals);
    $count = $stmt->rowCount();
    if ($json == true) {
    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "failure"));
    }
    }
    return $count;
}

//============================= for food app d

// can delet status= sucess in prapare admin only 
function updateDataAdmin($table, $data, $where, $json = false)
{
    global $con;
    $cols = array();
    $vals = array();

    foreach ($data as $key => $val) {
        $vals[] = "$val";
        $cols[] = "`$key` =  ? ";
    }
    $sql = "UPDATE $table SET " . implode(', ', $cols) . " WHERE $where";

    $stmt = $con->prepare($sql);
    $stmt->execute($vals);
    $count = $stmt->rowCount();
    if ($json == true) {
    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "failure"));
    }
    }
    return $count;
}



//======================================



function deleteData($table, $where, $json = true)
{
    global $con;
    $stmt = $con->prepare("DELETE FROM $table WHERE $where");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "failure"));
        }
    }
    return $count;
}

function imageUpload( $dir , $imageRequest)
{
  global $msgError;
  if (isset($_FILES[$imageRequest])) {
    $imagename  = rand(1000, 10000) . $_FILES[$imageRequest]['name'];
  $imagetmp   = $_FILES[$imageRequest]['tmp_name'];
  $imagesize  = $_FILES[$imageRequest]['size'];
  $allowExt   = array("jpg", "png", "gif", "mp3", "pdf","svg");
  $strToArray = explode(".", $imagename);
  $ext        = end($strToArray);
  $ext        = strtolower($ext);

  if (!empty($imagename) && !in_array($ext, $allowExt)) {
    $msgError = "EXT";
  }
  if ($imagesize > 2 * MB) {
    $msgError = "size";
  }
  if (empty($msgError)) {
    // move_uploaded_file($imagetmp,  "../upload/" . $imagename);
    move_uploaded_file($imagetmp,  $dir."/" . $imagename);

    return $imagename;
  } else {
    return "fail";
  }
  }
  else{
    return "Empty";
  }
  
}



function deleteFile($dir, $imagename)
{
    if (file_exists($dir . "/" . $imagename)) {
        unlink($dir . "/" . $imagename);
    }
}
//=================================================
function checkAuthenticate()
{
    if (isset($_SERVER['PHP_AUTH_USER'])  && isset($_SERVER['PHP_AUTH_PW'])) {
        if ($_SERVER['PHP_AUTH_USER'] != "wael" ||  $_SERVER['PHP_AUTH_PW'] != "wael12345") {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Page Not Found';
            exit;
        }
    } else {
        exit;
    }
    // End 
}
function  printFailure($message="none"){ echo json_encode(array("status"=>"failure","message"=>$message));}

function  printsuccess($message="none"){ echo json_encode(array("status"=>"success","message"=>$message));}

function result($count){

    if ($count >0) {
        printsuccess("success");
     }else {
        printFailure("failure");
     }

}

//===============================================================

function sendGCM($title, $message, $topic, $pageid, $pagename)
{


    $url = 'https://fcm.googleapis.com/fcm/send';

    $fields = array(
        "to" => '/topics/' . $topic,
        'priority' => 'high',
        'content_available' => true,

        'notification' => array(
            "body" =>  $message,
            "title" =>  $title,
            "click_action" => "FLUTTER_NOTIFICATION_CLICK",
            "sound" => "default"

        ),
        'data' => array(
            "pageid" => $pageid,
            "pagename" => $pagename
        )

    );


    $fields = json_encode($fields);
    $headers = array(
        'Authorization: key=' . "AAAAflgChQc:APA91bH81C2MYcnBSAIVo93SKd5meNj4uYSyUAOJoMIH1OFBYMkDdyM4CuDZ_yynXnsgcsupqiahBj8R4aw83A2dwZoRqGBMQmo3p9-PH7isTCfaG8DXGLnYcDuVF2yjg3oB_0LFuPkt",
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

    $result = curl_exec($ch);
    return $result;
    curl_close($ch);
}

function insertNotification($title,$body,$usersid,$topic, $pageid, $pagename){
    global $con;
    $stmt = $con->prepare("INSERT INTO `notification`( `notification_title`, `notification_body`, `notification_usersid`) VALUES (? ,? ,?)");
    $stmt->execute(array($title,$body,$usersid));

    sendGCM($title, $body, $topic, $pageid, $pagename); // send notification
    $count = $stmt->rowCount();
    return $count;

}


//============================ new sen message

// function sendGCM($title, $message, $topic, $pageid, $pagename)
// {


//     $url = 'https://fcm.googleapis.com/v1/projects/ecommeria/messages:send';

//     // $fields = array(
//     //     "to" => '/topics/' . $topic,
//     //     'priority' => 'high',
//     //     'content_available' => true,

//     //     'notification' => array(
//     //         "body" =>  $message,
//     //         "title" =>  $title,
//     //         "click_action" => "FLUTTER_NOTIFICATION_CLICK",
//     //         "sound" => "default"

//     //     ),
//     //     'data' => array(
//     //         "pageid" => $pageid,
//     //         "pagename" => $pagename
//     //     )

//     // );
// //========
// $fields = array(
//     "topic" =>  $topic,
//     'priority' => 'high',
//     'content_available' => true,

//     'notification' => array(
//         "body" =>  $message,
//         "title" =>  $title,
//         "click_action" => "FLUTTER_NOTIFICATION_CLICK",
//         "sound" => "default"

//     ),
//     'data' => array(
//         "pageid" => $pageid,
//         "pagename" => $pagename
//     )

// );

//     $fields = json_encode($fields);
//     $headers = array(
//         'Authorization: Bearer ' . "AAAAbqyJrkw:APA91bERK8hqD1i29ySvA5MEYYHWpafMngazqhiTmMeu3Y6ItA7KtdgfkGVjDMYUq0qYAmJVN4ZDlLbiaQuSWnUmNazgp-cwA0GA8S6vhdJ2aWh4y9xeSSR15s0b9Wr10TwoQL8Y0B3r",
//         'Content-Type: application/json'
//     );

//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_POST, true);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

//     $result = curl_exec($ch);
//     return $result;
//     curl_close($ch);
// }

/// =======================================

// function sendEmail($to,$title,$body){
//  $header="From : App registration@gmail.com";
    
//  mail($to,$title,$messageو$header);
   
// }
// ===== كود محسن بواسطه claude
// function sendGCM($title, $message, $topic, $pageid, $pagename)
// {
//     $url = 'https://fcm.googleapis.com/v1/projects/delivery-dc031/messages:send';
    
//     // التنسيق الصحيح والمحسن للـ FCM v1 API
//     $fields = [
//         "message" => [
//             "topic" => $topic,
//             "notification" => [
//                 "title" => $title,
//                 "body" => $message
//             ],
//             "data" => [
//                 "pageid" => (string)$pageid,
//                 "pagename" => $pagename,
//                 "click_action" => "FLUTTER_NOTIFICATION_CLICK"
//             ],
//             "android" => [
//                 "priority" => "high",
//                 "notification" => [
//                     "sound" => "default",
//                     "click_action" => "FLUTTER_NOTIFICATION_CLICK"
//                 ]
//             ],
//             "apns" => [
//                 "headers" => [
//                     "apns-priority" => "10"
//                 ],
//                 "payload" => [
//                     "aps" => [
//                         "alert" => [
//                             "title" => $title,
//                             "body" => $message
//                         ],
//                         "sound" => "default",
//                         "content-available" => 1
//                     ]
//                 ]
//             ]
//         ]
//     ];
    
//     $headers = [
//         'Authorization: Bearer ' . "ya29.c.c0ASRK0GaiS1jBB5nQqzfxhD2GzgtFHDgYFJ_LKESRuy26xVd7dCkDvLTd7sH1_rC2IJ-kvw8KNgjQU8EovvNihfG2yI2CqgQOfGGTAjiGKj513pIp9FuzWyO5_u04OdFRvwVebtMznBM62n3Q-4QMBCO-8cjgM4lqoloqwuWyeCKuOkyAwqxU5vQP-42cpUSbdrCFOenFxTD2saJurD-TEfR7c2yMS51cDKcrSljuI8-a-hCXAUc21nt10t9VvWZK1IBrDQK963Qj9CO_28kBMinZyiv5kO6zjLFkX4THiYS31m4nJQ79gnS4WsIywssg8PFg3p6nWNeN_tIahs-51R-Fg1gETM8IUF-dZDU0we365G7p-RPNjvTEZ5LVN389AO3kBk948Op2uwt582V39fJqln3X_voc5h166ivJZJ9lljXpm52wwu1FV0f-goRzh1Yitbxc1kRB8xBv9fh9d7eFywXmlR8ZjlR3Bc3Fhq-Fv0O0er3WhubS-O9IkMFuhZ3ziecqVaW5yR2QpJ7b3uav-vOguSqnStU5dqytggcJI0kpMSxi3MldlB2qJQeVyZ7MmInm8Y4ymhM4jrSkFmF3bF9Yx9g4l1Mrv636gJSd-ORdpofQYIkkw4dJ7O4x4u3YjjM50htYpjSlvZdtJ6vMUbnpXZ643l5dl08f2iZ87xMJ6OpjssVB1FM-ZyehMox0zIFWFj9kbqj2np3kbBSa8RRX-gYk_6boSO_sri80g2IFWtVhXgmbeWYX7QcQkYF76mzrwbt6kY1j4t0gl2Uc26wtXFFcZ3xOiB8ygOjUpFhQtWjzhinni04r4biYUt5ZobuXkSn78q83pgS8itFM3XjmcvuXhnIOgtUm6vOph-iJg-fagv_V6kYoOdr2BOodwSQ56702Z7iJ6OaVv-cbbnyrtkbVazvZqxopSnSjlbuzrWJsrXdaSX97M82aiUOII4_xOx3poxsiy7sRfiMtYjtv5tg92fVnJ9yg",
//         'Content-Type: application/json'
//     ];
    
//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_POST, true);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//     curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
//     $result = curl_exec($ch);
//     // $result = curl_exec($ch);
//     return $result;
//     curl_close($ch);
//     // $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//     // $error = curl_error($ch);
//     // curl_close($ch); // تم تصحيح الترتيب
    
//     // // معالجة الأخطاء والاستجابة
//     // if ($error) {
//     //     return [
//     //         'success' => false,
//     //         'error' => 'cURL Error: ' . $error
//     //     ];
//     // }
    
//     // $response = json_decode($result, true);
    
//     // if ($httpCode == 200) {
//     //     return [
//     //         'success' => true,
//     //         'message' => 'Notification sent successfully',
//     //         'response' => $response
//     //     ];
//     // } else {
//     //     return [
//     //         'success' => false,
//     //         'http_code' => $httpCode,
//     //         'error' => 'FCM Error',
//     //         'response' => $response
//     //     ];
//     // }
// }

// // نسخة مبسطة من الكود الأصلي مع الإصلاحات الأساسية فقط
// function sendGCM_Fixed($title, $message, $topic, $pageid, $pagename)
// {
//     $url = 'https://fcm.googleapis.com/v1/projects/delivery-dc031/messages:send';
    
//     // الكود الأصلي مع تصحيحات بسيطة
//     $fields = [
//         "message" => [
//             "topic" => $topic,
//             "notification" => [
//                 "body" => $message,
//                 "title" => $title,
//                 "click_action" => "FLUTTER_NOTIFICATION_CLICK",
//                 "sound" => "default"
//             ],
//             "data" => [
//                 "pageid" => (string)$pageid,
//                 "pagename" => $pagename
//             ],
//             "android" => [
//                 "priority" => "high"
//             ]
//         ]
//     ];
    
//     $headers = [
//         'Authorization: Bearer ' . "ya29.c.c0ASRK0GaiS1jBB5nQqzfxhD2GzgtFHDgYFJ_LKESRuy26xVd7dCkDvLTd7sH1_rC2IJ-kvw8KNgjQU8EovvNihfG2yI2CqgQOfGGTAjiGKj513pIp9FuzWyO5_u04OdFRvwVebtMznBM62n3Q-4QMBCO-8cjgM4lqoloqwuWyeCKuOkyAwqxU5vQP-42cpUSbdrCFOenFxTD2saJurD-TEfR7c2yMS51cDKcrSljuI8-a-hCXAUc21nt10t9VvWZK1IBrDQK963Qj9CO_28kBMinZyiv5kO6zjLFkX4THiYS31m4nJQ79gnS4WsIywssg8PFg3p6nWNeN_tIahs-51R-Fg1gETM8IUF-dZDU0we365G7p-RPNjvTEZ5LVN389AO3kBk948Op2uwt582V39fJqln3X_voc5h166ivJZJ9lljXpm52wwu1FV0f-goRzh1Yitbxc1kRB8xBv9fh9d7eFywXmlR8ZjlR3Bc3Fhq-Fv0O0er3WhubS-O9IkMFuhZ3ziecqVaW5yR2QpJ7b3uav-vOguSqnStU5dqytggcJI0kpMSxi3MldlB2qJQeVyZ7MmInm8Y4ymhM4jrSkFmF3bF9Yx9g4l1Mrv636gJSd-ORdpofQYIkkw4dJ7O4x4u3YjjM50htYpjSlvZdtJ6vMUbnpXZ643l5dl08f2iZ87xMJ6OpjssVB1FM-ZyehMox0zIFWFj9kbqj2np3kbBSa8RRX-gYk_6boSO_sri80g2IFWtVhXgmbeWYX7QcQkYF76mzrwbt6kY1j4t0gl2Uc26wtXFFcZ3xOiB8ygOjUpFhQtWjzhinni04r4biYUt5ZobuXkSn78q83pgS8itFM3XjmcvuXhnIOgtUm6vOph-iJg-fagv_V6kYoOdr2BOodwSQ56702Z7iJ6OaVv-cbbnyrtkbVazvZqxopSnSjlbuzrWJsrXdaSX97M82aiUOII4_xOx3poxsiy7sRfiMtYjtv5tg92fVnJ9yg",
//         'Content-Type: application/json'
//     ];
    
//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_POST, true);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    
//     $result = curl_exec($ch);
//     $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//     curl_close($ch); // تم تصحيح الترتيب
    
//     // استجابة مبسطة
//     if ($httpCode == 200) {
//         return $result;
//     } else {
//         return json_encode([
//             'error' => 'HTTP ' . $httpCode,
//             'response' => $result
//         ]);
//     }
// }

// // اختبار الكود
// echo "=== اختبار الكود المحسن ===\n";
// $result = sendGCM(
//     "إشعار تجريبي",
//     "هذا اختبار للكود المحسن",
//     "test_topic",
//     123,
//     "home"
// );

// if ($result['success']) {
//     echo "✅ تم إرسال الإشعار بنجاح!\n";
// } else {
//     echo "❌ فشل الإرسال: " . $result['error'] . "\n";
// }

// print_r($result);
// //=========