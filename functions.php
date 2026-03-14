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

//=============================================================== وائل ابوحمزهالكود قديم *** لن يعمل ****

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

    sendGCM($title, $body, $topic, $pageid, $pagename); // send notification ذات تقييم 93% يستخدم
    $count = $stmt->rowCount();
    return $count;

}
//===========تم تحسيب بواسطه chat + claude 26-7-2025  -- هذا الكود سوف لايعمل فى المستقبل يجبب عد م الاستخدام ==
// function sendGCM($title, $message, $topic, $pageid = null, $pagename = null, $options = []) 
// {
//     // إعدادات افتراضية
//     $defaultOptions = [
//         'server_key' => 'AAAAbqyJrkw:APA91bERK8hqD1i29ySvA5MEYYHWpafMngazqhiTmMeu3Y6ItA7KtdgfkGVjDMYUq0qYAmJVN4ZDlLbiaQuSWnUmNazgp-cwA0GA8S6vhdJ2aWh4y9xeSSR15s0b9Wr10TwoQL8Y0B3r',
//         'priority' => 'high',
//         'sound' => 'default',
//         'icon' => 'ic_notification',
//         'color' => '#FF6B6B',
//         'timeout' => 30,
//         'return_details' => false
//     ];
    
//     $options = array_merge($defaultOptions, $options);
    
//     try {
//         // التحقق من المعاملات المطلوبة
//         if (empty($title) || empty($message) || empty($topic)) {
//             throw new Exception('العنوان والرسالة والموضوع مطلوبة');
//         }
        
//         $url = 'https://fcm.googleapis.com/fcm/send';
        
//         // بناء البيانات
//         $payload = [
//             "to" => '/topics/' . $topic,
//             'priority' => $options['priority'],
//             'content_available' => true,
//             'notification' => [
//                 "body" => $message,
//                 "title" => $title,
//                 "click_action" => "FLUTTER_NOTIFICATION_CLICK",
//                 "sound" => $options['sound'],
//                 "icon" => $options['icon'],
//                 "color" => $options['color']
//             ],
//             'data' => [
//                 "timestamp" => time(),
//                 "type" => "navigation"
//             ]
//         ];
        
//         // إضافة البيانات الإضافية إذا كانت متوفرة
//         if ($pageid !== null) {
//             $payload['data']['pageid'] = (string)$pageid;
//         }
//         if ($pagename !== null) {
//             $payload['data']['pagename'] = $pagename;
//         }
        
//         // تحويل إلى JSON
//         $jsonPayload = json_encode($payload);
        
//         if (json_last_error() !== JSON_ERROR_NONE) {
//             throw new Exception('خطأ في تحويل البيانات إلى JSON: ' . json_last_error_msg());
//         }
        
//         // إعداد الHeaders
//         $headers = [
//             'Authorization: key=' . $options['server_key'],
//             'Content-Type: application/json',
//             'Content-Length: ' . strlen($jsonPayload)
//         ];
        
//         // إعداد cURL محسن
//         $ch = curl_init();
//         curl_setopt_array($ch, [
//             CURLOPT_URL => $url,
//             CURLOPT_POST => true,
//             CURLOPT_HTTPHEADER => $headers,
//             CURLOPT_RETURNTRANSFER => true,
//             CURLOPT_POSTFIELDS => $jsonPayload,
//             CURLOPT_TIMEOUT => $options['timeout'],
//             CURLOPT_CONNECTTIMEOUT => 10,
//             CURLOPT_SSL_VERIFYPEER => true,
//             CURLOPT_SSL_VERIFYHOST => 2,
//             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
//             CURLOPT_FOLLOWLOCATION => true,
//             CURLOPT_MAXREDIRS => 3,
//             CURLOPT_USERAGENT => 'FCM-PHP-Client/1.0'
//         ]);
        
//         $result = curl_exec($ch);
//         $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//         $curlError = curl_error($ch);
//         curl_close($ch);
        
//         // التحقق من أخطاء cURL
//         if ($result === false) {
//             throw new Exception("خطأ في الاتصال: " . $curlError);
//         }
        
//         // فك تشفير الاستجابة
//         $response = json_decode($result, true);
        
//         if (json_last_error() !== JSON_ERROR_NONE) {
//             throw new Exception('خطأ في قراءة استجابة الخادم: ' . json_last_error_msg());
//         }
        
//         // التحقق من رمز الاستجابة
//         if ($httpCode !== 200) {
//             $errorMessage = 'خطأ HTTP: ' . $httpCode;
//             if (isset($response['error'])) {
//                 $errorMessage .= ' - ' . $response['error'];
//             }
//             throw new Exception($errorMessage);
//         }
        
//         // التحقق من نجاح الإرسال
//         if (isset($response['failure']) && $response['failure'] > 0) {
//             $errorDetails = isset($response['results'][0]['error']) 
//                 ? $response['results'][0]['error'] 
//                 : 'خطأ غير محدد';
//             throw new Exception('فشل في إرسال الإشعار: ' . $errorDetails);
//         }
        
//         // إرجاع النتيجة حسب الخيارات
//         if ($options['return_details']) {
//             return [
//                 'success' => true,
//                 'message_id' => $response['results'][0]['message_id'] ?? null,
//                 'response' => $response,
//                 'http_code' => $httpCode
//             ];
//         }
        
//         return $result;
        
//     } catch (Exception $e) {
//         // تسجيل الخطأ (اختياري)
//         error_log("FCM Error: " . $e->getMessage());
        
//         if ($options['return_details']) {
//             return [
//                 'success' => false,
//                 'error' => $e->getMessage(),
//                 'http_code' => $httpCode ?? null
//             ];
//         }
        
//         return json_encode(['error' => $e->getMessage()]);
//     }
// }

///////////////////////////////////////////////////////////////////////////////////////////////

//===  ******  االتقييم %85 -- 14/3/2026

//  بواسطه chat  و لكن اقل جود  من claude هو اخر تدحث firebase  27-7-20025باستخدام HTTP v1 APIاخر تحديث
// أولاً: ⚙️ التجهيز المسبق لمرة واحدة
// 1. أنشئ حساب خدمة (Service Account):
// من Google Cloud Console:

// arduino
// نسخ
// تحرير
// https://console.cloud.google.com/iam-admin/serviceaccounts
// اختر المشروع المرتبط بـ Firebase.

// أنشئ حساب خدمة جديد.

// امنحه الصلاحية: "Firebase Admin SDK" > "Firebase Admin"

// نزّل ملف JSON الخاص بالحساب (service-account.json)

// 2. ثبت مكتبة Google Auth (باستخدام Composer):
// bash
// نسخ
// تحرير
// composer require google/auth
// ✅ الكود المحوّل باستخدام HTTP v1 API
// ✨ دالة sendFCM_HTTPv1 (بديلة sendGCM):
// php
// نسخ
// تحرير
// require_once 'vendor/autoload.php'; // تأكد من تحميل Google Auth

// function getAccessToken($serviceAccountPath) {
//     $client = new \Google\Auth\OAuth2([
//         'audience' => 'https://oauth2.googleapis.com/token',
//         'issuer' => json_decode(file_get_contents($serviceAccountPath), true)['client_email'],
//         'signingAlgorithm' => 'RS256',
//         'signingKey' => file_get_contents($serviceAccountPath),
//         'tokenCredentialUri' => 'https://oauth2.googleapis.com/token',
//         'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
//     ]);

//     $token = $client->fetchAuthToken();
//     return $token['access_token'] ?? null;
// }

// function sendFCM_HTTPv1($title, $message, $topic, $pageid = null, $pagename = null, $options = [])
// {
//     $defaultOptions = [
//         'service_account' => __DIR__ . '/service-account.json',
//         'project_id' => 'your-firebase-project-id', // 🔁 استبدله بمشروعك
//         'priority' => 'high',
//         'sound' => 'default',
//         'icon' => 'ic_notification',
//         'color' => '#FF6B6B',
//         'timeout' => 30,
//         'return_details' => false
//     ];

//     $options = array_merge($defaultOptions, $options);

//     try {
//         $accessToken = getAccessToken($options['service_account']);
//         if (!$accessToken) {
//             throw new Exception('فشل في الحصول على Access Token');
//         }

//         $url = "https://fcm.googleapis.com/v1/projects/{$options['project_id']}/messages:send";

//         $payload = [
//             'message' => [
//                 'topic' => $topic,
//                 'notification' => [
//                     'title' => $title,
//                     'body' => $message
//                 ],
//                 'data' => [
//                     'timestamp' => (string)time(),
//                     'type' => 'navigation',
//                     'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
//                 ],
//                 'android' => [
//                     'priority' => $options['priority'],
//                     'notification' => [
//                         'sound' => $options['sound'],
//                         'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
//                         'color' => $options['color'],
//                         'icon' => $options['icon']
//                     ]
//                 ],
//                 'apns' => [
//                     'payload' => [
//                         'aps' => [
//                             'sound' => $options['sound'],
//                             'content-available' => 1
//                         ]
//                     ]
//                 ]
//             ]
//         ];

//         if ($pageid !== null) {
//             $payload['message']['data']['pageid'] = (string)$pageid;
//         }
//         if ($pagename !== null) {
//             $payload['message']['data']['pagename'] = $pagename;
//         }

//         $jsonPayload = json_encode($payload);

//         $headers = [
//             'Authorization: Bearer ' . $accessToken,
//             'Content-Type: application/json',
//             'Content-Length: ' . strlen($jsonPayload)
//         ];

//         $ch = curl_init();
//         curl_setopt_array($ch, [
//             CURLOPT_URL => $url,
//             CURLOPT_POST => true,
//             CURLOPT_HTTPHEADER => $headers,
//             CURLOPT_RETURNTRANSFER => true,
//             CURLOPT_POSTFIELDS => $jsonPayload,
//             CURLOPT_TIMEOUT => $options['timeout'],
//             CURLOPT_CONNECTTIMEOUT => 10,
//             CURLOPT_SSL_VERIFYPEER => true,
//             CURLOPT_SSL_VERIFYHOST => 2,
//             CURLOPT_FOLLOWLOCATION => true,
//             CURLOPT_MAXREDIRS => 3,
//             CURLOPT_USERAGENT => 'FCM-HTTPv1-Client/1.0'
//         ]);

//         $result = curl_exec($ch);
//         $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//         $curlError = curl_error($ch);
//         curl_close($ch);

//         if ($result === false) {
//             throw new Exception("cURL Error: " . $curlError);
//         }

//         $response = json_decode($result, true);

//         if ($httpCode !== 200) {
//             throw new Exception("FCM Error ({$httpCode}): " . ($response['error']['message'] ?? 'غير معروف'));
//         }

//         if ($options['return_details']) {
//             return [
//                 'success' => true,
//                 'response' => $response,
//                 'http_code' => $httpCode
//             ];
//         }

//         return true;

//     } catch (Exception $e) {
//         error_log("FCM HTTPv1 Error: " . $e->getMessage());
//         return $options['return_details'] ? [
//             'success' => false,
//             'error' => $e->getMessage()
//         ] : false;
//     }
// }
// ✅ الاستخدام:
// php
// نسخ
// تحرير
// sendFCM_HTTPv1(
//     "رسالة جديدة 🔔",
//     "مرحبا بك، لدينا إشعار مميز!",
//     "news",
//     101,
//     "promotion",
//     [
//         'project_id' => 'your-project-id',
//         'service_account' => __DIR__ . '/service-account.json',
//         'return_details' => true
//     ]
// 


//************************************************************************** */

//.................التقييم 93% --14-3-2026 ********
//=================== 2**claude ai 27-7-2025 افضل من chat 

// require_once 'vendor/autoload.php';

// /**
//  * نسخة محسنة من getAccessToken مع cache بسيط
//  */
// function getAccessToken($serviceAccountPath) {
//     // Cache بسيط لتجنب طلب التوكن في كل مرة
//     static $cachedToken = null;
//     static $tokenExpiry = 0;
    
//     if ($cachedToken && time() < $tokenExpiry - 300) {
//         return $cachedToken;
//     }
    
//     try {
//         // التحقق من وجود الملف
//         if (!file_exists($serviceAccountPath)) {
//             throw new Exception("ملف Service Account غير موجود: {$serviceAccountPath}");
//         }
        
//         $serviceAccountData = json_decode(file_get_contents($serviceAccountPath), true);
//         if (!$serviceAccountData || !isset($serviceAccountData['client_email'])) {
//             throw new Exception("ملف Service Account غير صالح");
//         }
        
//         $client = new \Google\Auth\OAuth2([
//             'audience' => 'https://oauth2.googleapis.com/token',
//             'issuer' => $serviceAccountData['client_email'],
//             'signingAlgorithm' => 'RS256',
//             'signingKey' => $serviceAccountData['private_key'],
//             'tokenCredentialUri' => 'https://oauth2.googleapis.com/token',
//             'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
//         ]);

//         $token = $client->fetchAuthToken();
        
//         if (!isset($token['access_token'])) {
//             throw new Exception('فشل في الحصول على Access Token');
//         }
        
//         // حفظ التوكن مؤقتاً (55 دقيقة)
//         $cachedToken = $token['access_token'];
//         $tokenExpiry = time() + 3300;
        
//         return $cachedToken;
        
//     } catch (Exception $e) {
//         error_log("خطأ في getAccessToken: " . $e->getMessage());
//         return null;
//     }
// }

// /**
//  * نسخة محسنة من sendFCM_HTTPv1
//  */
// function sendFCM_HTTPv1($title, $message, $topic, $pageid = null, $pagename = null, $options = [])
// {
//     $defaultOptions = [
//         'service_account' => __DIR__ . '/service-account.json',
//         'project_id' => 'your-firebase-project-id', // 🔴 يجب تحديث هذا
//         'priority' => 'high',
//         'sound' => 'default',
//         'icon' => 'ic_notification',
//         'color' => '#FF6B6B',
//         'timeout' => 30,
//         'return_details' => false,
//         'retry_attempts' => 2 // إضافة محاولات إعادة
//     ];

//     $options = array_merge($defaultOptions, $options);
    
//     // التحقق من المعاملات الأساسية
//     if (empty($title) || empty($message) || empty($topic)) {
//         $error = 'العنوان والرسالة والموضوع مطلوبة';
//         return $options['return_details'] ? ['success' => false, 'error' => $error] : false;
//     }
    
//     // التحقق من Project ID
//     if ($options['project_id'] === 'your-firebase-project-id') {
//         $error = 'يجب تحديث project_id بمعرف مشروعك الفعلي';
//         return $options['return_details'] ? ['success' => false, 'error' => $error] : false;
//     }

//     $lastError = '';
    
//     // محاولة الإرسال مع إعادة المحاولة
//     for ($attempt = 1; $attempt <= $options['retry_attempts']; $attempt++) {
//         try {
//             $accessToken = getAccessToken($options['service_account']);
//             if (!$accessToken) {
//                 throw new Exception('فشل في الحصول على Access Token');
//             }

//             $url = "https://fcm.googleapis.com/v1/projects/{$options['project_id']}/messages:send";

//             // Payload محسن مع دعم أفضل للمنصات
//             $payload = [
//                 'message' => [
//                     'topic' => $topic,
//                     'notification' => [
//                         'title' => $title,
//                         'body' => $message
//                     ],
//                     'data' => [
//                         'timestamp' => (string)time(),
//                         'type' => 'navigation',
//                         'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
//                     ],
//                     'android' => [
//                         'priority' => strtoupper($options['priority']),
//                         'notification' => [
//                             'sound' => $options['sound'],
//                             'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
//                             'color' => $options['color'],
//                             'icon' => $options['icon'],
//                             'channel_id' => 'default_channel', // مهم للأندرويد الحديث
//                             'priority' => 'high'
//                         ],
//                         'ttl' => '86400s' // 24 ساعة
//                     ],
//                     'apns' => [
//                         'headers' => [
//                             'apns-priority' => '10'
//                         ],
//                         'payload' => [
//                             'aps' => [
//                                 'sound' => $options['sound'],
//                                 'content-available' => 1,
//                                 'alert' => [
//                                     'title' => $title,
//                                     'body' => $message
//                                 ]
//                             ]
//                         ]
//                     ]
//                 ]
//             ];

//             // إضافة البيانات الإضافية
//             if ($pageid !== null) {
//                 $payload['message']['data']['pageid'] = (string)$pageid;
//             }
//             if ($pagename !== null) {
//                 $payload['message']['data']['pagename'] = $pagename;
//             }

//             $jsonPayload = json_encode($payload, JSON_UNESCAPED_UNICODE);
            
//             // التحقق من صحة JSON
//             if (json_last_error() !== JSON_ERROR_NONE) {
//                 throw new Exception('خطأ في تحويل البيانات إلى JSON: ' . json_last_error_msg());
//             }

//             $headers = [
//                 'Authorization: Bearer ' . $accessToken,
//                 'Content-Type: application/json; charset=utf-8',
//                 'Content-Length: ' . strlen($jsonPayload),
//                 'Accept: application/json'
//             ];

//             // إعدادات cURL محسنة
//             $ch = curl_init();
//             curl_setopt_array($ch, [
//                 CURLOPT_URL => $url,
//                 CURLOPT_POST => true,
//                 CURLOPT_HTTPHEADER => $headers,
//                 CURLOPT_RETURNTRANSFER => true,
//                 CURLOPT_POSTFIELDS => $jsonPayload,
//                 CURLOPT_TIMEOUT => $options['timeout'],
//                 CURLOPT_CONNECTTIMEOUT => 10,
//                 CURLOPT_SSL_VERIFYPEER => true,
//                 CURLOPT_SSL_VERIFYHOST => 2,
//                 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0, // HTTP/2
//                 CURLOPT_ENCODING => 'gzip, deflate', // Compression
//                 CURLOPT_FOLLOWLOCATION => true,
//                 CURLOPT_MAXREDIRS => 3,
//                 CURLOPT_USERAGENT => 'FCM-HTTPv1-Client/2.0'
//             ]);

//             $result = curl_exec($ch);
//             $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//             $curlError = curl_error($ch);
//             curl_close($ch);

//             if ($result === false) {
//                 throw new Exception("cURL Error: " . $curlError);
//             }

//             $response = json_decode($result, true);
            
//             // التحقق من JSON response
//             if (json_last_error() !== JSON_ERROR_NONE) {
//                 throw new Exception('خطأ في قراءة استجابة الخادم: ' . json_last_error_msg());
//             }

//             // التحقق من نجاح الطلب
//             if ($httpCode === 200 && isset($response['name'])) {
//                 // نجح الإرسال
//                 if ($options['return_details']) {
//                     return [
//                         'success' => true,
//                         'message_id' => $response['name'],
//                         'response' => $response,
//                         'http_code' => $httpCode,
//                         'attempt' => $attempt
//                     ];
//                 }
//                 return true;
//             }

//             // معالجة الأخطاء المحسنة
//             $errorMessage = "FCM Error ({$httpCode})";
//             if (isset($response['error']['message'])) {
//                 $errorMessage .= ": " . $response['error']['message'];
//             } else {
//                 $errorMessage .= ": " . ($result ?: 'استجابة فارغة');
//             }
            
//             throw new Exception($errorMessage);

//         } catch (Exception $e) {
//             $lastError = $e->getMessage();
//             error_log("FCM HTTPv1 Error (المحاولة {$attempt}): " . $lastError);
            
//             // إذا كان هذا آخر محاولة أو خطأ غير قابل للإعادة
//             if ($attempt >= $options['retry_attempts'] || 
//                 strpos($lastError, 'Authentication') !== false ||
//                 strpos($lastError, 'Invalid') !== false ||
//                 strpos($lastError, 'Permission') !== false) {
//                 break;
//             }
            
//             // انتظار قصير قبل المحاولة التالية
//             if ($attempt < $options['retry_attempts']) {
//                 sleep(1);
//             }
//         }
//     }

//     // فشل في جميع المحاولات
//     if ($options['return_details']) {
//         return [
//             'success' => false,
//             'error' => $lastError,
//             'attempts' => $options['retry_attempts']
//         ];
//     }
    
//     return false;
// }

// /**
//  * دالة مساعدة للتحقق من الإعدادات
//  */
// function validateFirebaseSetup($serviceAccountPath, $projectId) {
//     $issues = [];
    
//     if (!file_exists($serviceAccountPath)) {
//         $issues[] = "ملف Service Account غير موجود: {$serviceAccountPath}";
//     }
    
//     if ($projectId === 'your-firebase-project-id') {
//         $issues[] = "يجب تحديث project_id في الخيارات";
//     }
    
//     if (!class_exists('\Google\Auth\OAuth2')) {
//         $issues[] = "مكتبة Google Auth غير مثبتة. قم بتشغيل: composer require google/auth";
//     }
    
//     return $issues;
// }

// /**
//  * مثال على الاستخدام
//  */
// function testFCM() {
//     // التحقق من الإعدادات
//     $issues = validateFirebaseSetup(__DIR__ . '/service-account.json', 'your-firebase-project-id');
    
//     if (!empty($issues)) {
//         echo "مشاكل في الإعدادات:\n";
//         foreach ($issues as $issue) {
//             echo "- {$issue}\n";
//         }
//         return;
//     }
    
//     // إرسال إشعار تجريبي
//     $result = sendFCM_HTTPv1(
//         'إشعار تجريبي',
//         'مرحباً من Firebase HTTP v1 API',
//         'test',
//         123,
//         'صفحة التجربة',
//         [
//             'project_id' => 'your-actual-project-id', // 🔴 حدث هذا
//             'return_details' => true
//         ]
//     );
    
//     if ($result['success']) {
//         echo "✅ تم إرسال الإشعار بنجاح!\n";
//         echo "Message ID: " . $result['message_id'] . "\n";
//     } else {
//         echo "❌ فشل الإرسال: " . $result['error'] . "\n";
//     }
// }

/////************************************************************************** */


//******** تلك الاكواد سيئه ... لا تستخدم ملغى  */

//============================ new sen message هذا الكود سئ و بواسطه chat + claude هذا الكود ملغى 

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