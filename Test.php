<?php
session_start();
date_default_timezone_set("Asia/Bangkok");

class thsms {
     var $api_url   = 'http://www.thsms.com/api/rest';
     var $username  = null;
     var $password  = null;

    public function getCredit()
    {
        $params['method']   = 'credit';
        $params['username'] = $this->username;
        $params['password'] = $this->password;

        $result = $this->curl( $params);

        $xml = @simplexml_load_string( $result);

        if (!is_object($xml))
        {
            return array( FALSE, 'Respond error');

        } else {

            if ($xml->credit->status == 'success')
            {
                return array( TRUE, $xml->credit->status);
            } else {
                return array( FALSE, $xml->credit->message);
            }
        }
    }

    public function send( $from='VIP', $to=null, $message=null)
    {
        $params['method']   = 'send';
        $params['username'] = $this->username;
        $params['password'] = $this->password;

        $params['from']     = $from;
        $params['to']       = $to;
        $params['message']  = $message;

        if (is_null( $params['to']) || is_null( $params['message']))
        {
            return FALSE;
        }

        $result = $this->curl( $params);
        $xml = @simplexml_load_string( $result);
        if (!is_object($xml))
        {
            return array( FALSE, 'Respond error');
        } else {
            if ($xml->send->status == 'success')
            {
                return array( TRUE, $xml->send->uuid);
            } else {
                return array( FALSE, $xml->send->message);
            }
        }
    }

    private function curl( $params=array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query( $params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response  = curl_exec($ch);
        $lastError = curl_error($ch);
        $lastReq = curl_getinfo($ch);
        curl_close($ch);

        return $response;
    }
}

$update_response = file_get_contents("php://input");
if(!empty($update_response)){
  $fp = fopen('results.json', 'w');
  fwrite($fp, $update_response);
  fclose($fp);
}

$json_url = "https://niskzeed.xyz/Api/Line/results.json";
$json = file_get_contents($json_url);

$data = json_decode($json);
echo 'Action: '.$data->queryResult->action;

echo '<pre>'.print_r($data, true).'</pre>';

$userId = $data->originalDetectIntentRequest->payload->data->source->userId;

$dbc = mysqli_connect("localhost","root","Rampage28092560","SCTSPC_zenezzthailand")
// $dbc = mysqli_connect("localhost","root","Rampage28092560","Dev1_dev-zenezzthailand")
	or die("Error:".mysqli_connect_error());
$dbc->query("set NAMES utf8");

// die();

//$userId = 'U85b55b7fa8f378cf956a843bcb6ee7f0'; //NiSK ID

// die();

$ACT = $data->queryResult->action;

switch ($ACT) {
  case 'AddSellData.AddSellData-custom':
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.line.me/v2/bot/message/push",
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\n   \"to\":\"$userId\",\n   \"messages\":[\n   {\n     \"type\": \"flex\",\n     \"altText\": \"Flex Message\",\n     \"contents\": {\n       \"type\": \"bubble\",\n       \"header\": {\n         \"type\": \"box\",\n         \"layout\": \"horizontal\",\n         \"contents\": [\n           {\n             \"type\": \"text\",\n             \"text\": \"NEWS DIGEST\",\n             \"size\": \"sm\",\n             \"weight\": \"bold\",\n             \"color\": \"#AAAAAA\"\n           }\n         ]\n       },\n       \"hero\": {\n         \"type\": \"image\",\n         \"url\": \"https://scdn.line-apps.com/n/channel_devcenter/img/fx/01_4_news.png\",\n         \"size\": \"full\",\n         \"aspectRatio\": \"20:13\",\n         \"aspectMode\": \"cover\",\n         \"action\": {\n           \"type\": \"uri\",\n           \"label\": \"Action\",\n           \"uri\": \"https://linecorp.com/\"\n         }\n       },\n       \"body\": {\n         \"type\": \"box\",\n         \"layout\": \"horizontal\",\n         \"spacing\": \"md\",\n         \"contents\": [\n           {\n             \"type\": \"box\",\n             \"layout\": \"vertical\",\n             \"flex\": 1,\n             \"contents\": [\n               {\n                 \"type\": \"image\",\n                 \"url\": \"https://scdn.line-apps.com/n/channel_devcenter/img/fx/02_1_news_thumbnail_1.png\",\n                 \"gravity\": \"bottom\",\n                 \"size\": \"sm\",\n                 \"aspectRatio\": \"4:3\",\n                 \"aspectMode\": \"cover\"\n               },\n               {\n                 \"type\": \"image\",\n                 \"url\": \"https://scdn.line-apps.com/n/channel_devcenter/img/fx/02_1_news_thumbnail_2.png\",\n                 \"margin\": \"md\",\n                 \"size\": \"sm\",\n                 \"aspectRatio\": \"4:3\",\n                 \"aspectMode\": \"cover\"\n               }\n             ]\n           },\n           {\n             \"type\": \"box\",\n             \"layout\": \"vertical\",\n             \"flex\": 2,\n             \"contents\": [\n               {\n                 \"type\": \"text\",\n                 \"text\": \"7 Things to Know for Today\",\n                 \"flex\": 1,\n                 \"size\": \"xs\",\n                 \"gravity\": \"top\"\n               },\n               {\n                 \"type\": \"separator\"\n               },\n               {\n                 \"type\": \"text\",\n                 \"text\": \"Hay fever goes wild\",\n                 \"flex\": 2,\n                 \"size\": \"xs\",\n                 \"gravity\": \"center\"\n               },\n               {\n                 \"type\": \"separator\"\n               },\n               {\n                 \"type\": \"text\",\n                 \"text\": \"LINE Pay Begins Barcode Payment Service\",\n                 \"flex\": 2,\n                 \"size\": \"xs\",\n                 \"gravity\": \"center\"\n               },\n               {\n                 \"type\": \"separator\"\n               },\n               {\n                 \"type\": \"text\",\n                 \"text\": \"LINE Adds LINE Wallet\",\n                 \"flex\": 1,\n                 \"size\": \"xs\",\n                 \"gravity\": \"bottom\"\n               }\n             ]\n           }\n         ]\n       },\n       \"footer\": {\n         \"type\": \"box\",\n         \"layout\": \"horizontal\",\n         \"contents\": [\n           {\n             \"type\": \"button\",\n             \"action\": {\n               \"type\": \"uri\",\n               \"label\": \"More\",\n               \"uri\": \"https://linecorp.com\"\n             }\n           }\n         ]\n       }\n     }\n   }\n   ]\n}",
    CURLOPT_HTTPHEADER => array(
      "authorization: Bearer sWgpfw4w11QeoHoA78HESv1oajCUv4X5BRNl3FtG38/23k2GVEFF5cvnPX89WzwPO1MRiW0LCGtDCGQmfoTW08SKNVE2sg+yvRTapIJkFLeb3rCpXgLeWXni06bjUaReKmI816JBR0PjhM0Dv3mNTgdB04t89/1O/w1cDnyilFU=",
      "cache-control: no-cache",
      "content-type: application/json",
      "postman-token: 7f766920-b207-53c4-6059-6d20ceec77ea",
    ) ,
  ));
  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  if ($err){
  echo "cURL Error #:" . $err;
  }
  else
  {
  echo '<pre>'.print_r(json_decode($response), true).'</pre>';
  }
  break;

  case 'Confirm_yourself':

  $username = $data->queryResult->outputContexts[0]->parameters->Username[0];
  $password = $data->queryResult->outputContexts[0]->parameters->password[0];

  $sql = mysqli_query($dbc, "SELECT * FROM Users_Downline WHERE DownlineID = '$username'");
  $res = mysqli_fetch_assoc($sql);

  $username_th = $res['NameLast'];
  $id_card = $res['Idcard'];
  $level = $res['Level'];

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.line.me/v2/bot/message/push",
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\n   \"to\":\"$userId\",\n   \"messages\":[\n   {\n     \"type\": \"flex\",\n     \"altText\": \"Flex Message\",\n     \"contents\": {\n       \"type\": \"bubble\",\n       \"body\": {\n         \"type\": \"box\",\n         \"layout\": \"vertical\",\n         \"contents\": [\n           {\n             \"type\": \"text\",\n             \"text\": \"ยืนยันตัวตน\",\n             \"size\": \"xl\",\n             \"weight\": \"bold\"\n           },\n           {\n             \"type\": \"box\",\n             \"layout\": \"vertical\",\n             \"spacing\": \"sm\",\n             \"margin\": \"lg\",\n             \"contents\": [\n               {\n                 \"type\": \"box\",\n                 \"layout\": \"baseline\",\n                 \"spacing\": \"sm\",\n                 \"contents\": [\n                   {\n                     \"type\": \"text\",\n                     \"text\": \"ชื่อ - นามสกุล:\",\n                     \"flex\": 5,\n                     \"size\": \"sm\",\n                     \"color\": \"#AAAAAA\"\n                   },\n                   {\n                     \"type\": \"text\",\n                     \"text\": \"$username_th\",\n                     \"flex\": 5,\n                     \"size\": \"sm\",\n                     \"color\": \"#666666\",\n                     \"wrap\": true\n                   }\n                 ]\n               },\n               {\n                 \"type\": \"box\",\n                 \"layout\": \"baseline\",\n                 \"spacing\": \"sm\",\n                 \"contents\": [\n                   {\n                     \"type\": \"text\",\n                     \"text\": \"รหัสบัตรประชาชน:\",\n                     \"flex\": 5,\n                     \"size\": \"sm\",\n                     \"color\": \"#AAAAAA\"\n                   },\n                   {\n                     \"type\": \"text\",\n                     \"text\": \"$id_card\",\n                     \"flex\": 5,\n                     \"size\": \"sm\",\n                     \"color\": \"#666666\",\n                     \"wrap\": true\n                   }\n                 ]\n               }\n             ]\n           },\n           {\n             \"type\": \"box\",\n             \"layout\": \"baseline\",\n             \"spacing\": \"sm\",\n             \"contents\": [\n               {\n                 \"type\": \"text\",\n                 \"text\": \"เลเวล:\",\n                 \"flex\": 5,\n                 \"size\": \"sm\",\n                 \"color\": \"#AAAAAA\"\n               },\n               {\n                 \"type\": \"text\",\n                 \"text\": \"$level\",\n                 \"flex\": 5,\n                 \"size\": \"sm\",\n                 \"color\": \"#666666\",\n                 \"wrap\": true\n               }\n             ]\n           }\n         ]\n       },\n       \"footer\": {\n         \"type\": \"box\",\n         \"layout\": \"vertical\",\n         \"flex\": 0,\n         \"spacing\": \"sm\",\n         \"contents\": [\n           {\n             \"type\": \"button\",\n             \"action\": {\n               \"type\": \"message\",\n               \"label\": \"ยืนยัน\",\n               \"text\": \"ถูกต้อง\"\n             },\n             \"style\": \"primary\"\n           },\n           {\n             \"type\": \"button\",\n             \"action\": {\n               \"type\": \"message\",\n               \"label\": \"ยกเลิก\",\n               \"text\": \"ยกเลิก\"\n             },\n             \"height\": \"sm\",\n             \"style\": \"secondary\"\n           },\n           {\n             \"type\": \"spacer\",\n             \"size\": \"sm\"\n           }\n         ]\n       }\n     }\n   }\n   ]\n}",
    CURLOPT_HTTPHEADER => array(
      "authorization: Bearer sWgpfw4w11QeoHoA78HESv1oajCUv4X5BRNl3FtG38/23k2GVEFF5cvnPX89WzwPO1MRiW0LCGtDCGQmfoTW08SKNVE2sg+yvRTapIJkFLeb3rCpXgLeWXni06bjUaReKmI816JBR0PjhM0Dv3mNTgdB04t89/1O/w1cDnyilFU=",
      "cache-control: no-cache",
      "content-type: application/json",
      "postman-token: 7f766920-b207-53c4-6059-6d20ceec77ea",
    ) ,
  ));
  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  if ($err){
  echo "cURL Error #:" . $err;
  }
  else
  {
  echo '<pre>'.print_r(json_decode($response), true).'</pre>';
  }

  break;

  case 'include_customer_data':
    $sell_type = $data->queryResult->outputContexts[4]->parameters->Sell_type;
    $item_type = $data->queryResult->outputContexts[4]->parameters->Item_Type;
    $username = $data->queryResult->outputContexts[4]->parameters->Username[0];
    $password = $data->queryResult->outputContexts[4]->parameters->password[0];
    $customer_name = $data->queryResult->outputContexts[4]->parameters->customer_name[0];
    $customer_tel = $data->queryResult->outputContexts[4]->parameters->customer_tel;
    $item_amt = $data->queryResult->outputContexts[4]->parameters->product_amt.' กล่อง';

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.line.me/v2/bot/message/push",
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "{\n   \"to\":\"$userId\",\n   \"messages\":[\n   {\n     \"type\": \"flex\",\n     \"altText\": \"Flex Message\",\n     \"contents\": {\n       \"type\": \"bubble\",\n       \"body\": {\n         \"type\": \"box\",\n         \"layout\": \"vertical\",\n         \"contents\": [\n           {\n             \"type\": \"text\",\n             \"text\": \"ยืนยันการทำรายการ\",\n             \"size\": \"xl\",\n             \"weight\": \"bold\"\n           },\n           {\n             \"type\": \"box\",\n             \"layout\": \"vertical\",\n             \"spacing\": \"sm\",\n             \"margin\": \"lg\",\n             \"contents\": [\n               {\n                 \"type\": \"box\",\n                 \"layout\": \"baseline\",\n                 \"spacing\": \"sm\",\n                 \"contents\": [\n                   {\n                     \"type\": \"text\",\n                     \"text\": \"ชื่อลูกค้า:\",\n                     \"flex\": 5,\n                     \"size\": \"sm\",\n                     \"color\": \"#AAAAAA\"\n                   },\n                   {\n                     \"type\": \"text\",\n                     \"text\": \"$customer_name\",\n                     \"flex\": 5,\n                     \"size\": \"sm\",\n                     \"color\": \"#666666\",\n                     \"wrap\": true\n                   }\n                 ]\n               },\n               {\n                 \"type\": \"box\",\n                 \"layout\": \"baseline\",\n                 \"spacing\": \"sm\",\n                 \"contents\": [\n                   {\n                     \"type\": \"text\",\n                     \"text\": \"เบอร์โทรศัพท์ลูกค้า:\",\n                     \"flex\": 5,\n                     \"size\": \"sm\",\n                     \"color\": \"#AAAAAA\"\n                   },\n                   {\n                     \"type\": \"text\",\n                     \"text\": \"$customer_tel\",\n                     \"flex\": 5,\n                     \"size\": \"sm\",\n                     \"color\": \"#666666\",\n                     \"wrap\": true\n                   }\n                 ]\n               },\n               {\n                 \"type\": \"box\",\n                 \"layout\": \"baseline\",\n                 \"spacing\": \"sm\",\n                 \"contents\": [\n                   {\n                     \"type\": \"text\",\n                     \"text\": \"จำนวนสินค้า:\",\n                     \"flex\": 5,\n                     \"size\": \"sm\",\n                     \"color\": \"#AAAAAA\"\n                   },\n                   {\n                     \"type\": \"text\",\n                     \"text\": \"$item_amt\",\n                     \"flex\": 5,\n                     \"size\": \"sm\",\n                     \"color\": \"#666666\",\n                     \"wrap\": true\n                   }\n                 ]\n               }\n             ]\n           }\n         ]\n       },\n       \"footer\": {\n         \"type\": \"box\",\n         \"layout\": \"vertical\",\n         \"flex\": 0,\n         \"spacing\": \"sm\",\n         \"contents\": [\n           {\n             \"type\": \"button\",\n             \"action\": {\n               \"type\": \"message\",\n               \"label\": \"ยืนยันการทำรายการ\",\n               \"text\": \"ยืนยัน\"\n             },\n             \"style\": \"primary\"\n           },\n           {\n             \"type\": \"button\",\n             \"action\": {\n               \"type\": \"message\",\n               \"label\": \"ยกเลิก\",\n               \"text\": \"ยกเลิก\"\n             },\n             \"height\": \"sm\",\n             \"style\": \"secondary\"\n           },\n           {\n             \"type\": \"spacer\",\n             \"size\": \"sm\"\n           }\n         ]\n       }\n     }\n   }\n   ]\n}",
      CURLOPT_HTTPHEADER => array(
        "authorization: Bearer sWgpfw4w11QeoHoA78HESv1oajCUv4X5BRNl3FtG38/23k2GVEFF5cvnPX89WzwPO1MRiW0LCGtDCGQmfoTW08SKNVE2sg+yvRTapIJkFLeb3rCpXgLeWXni06bjUaReKmI816JBR0PjhM0Dv3mNTgdB04t89/1O/w1cDnyilFU=",
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: 7f766920-b207-53c4-6059-6d20ceec77ea",
      ) ,
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err){
    echo "cURL Error #:" . $err;
    }
    else
    {
    echo '<pre>'.print_r(json_decode($response), true).'</pre>';
    }

  break;

  case 'Complete_SellType_1':

  $sell_type = $data->queryResult->outputContexts[4]->parameters->Sell_type;
  $item_type = $data->queryResult->outputContexts[4]->parameters->Item_Type;
  $username = $data->queryResult->outputContexts[4]->parameters->Username[0];
  $password = $data->queryResult->outputContexts[4]->parameters->password[0];
  $customer_name = $data->queryResult->outputContexts[4]->parameters->customer_name[0];
  $customer_tel = $data->queryResult->outputContexts[4]->parameters->customer_tel;
  $item_amt = $data->queryResult->outputContexts[4]->parameters->product_amt.' กล่อง';

  $data_all = "ยืนยันการทำรายการ

สินค้า: $item_type
จำนวน: $item_amt

ดำเนินการเรียบร้อยแล้วค่ะ ขอบพระคุณที่ใช้บริการค่ะ";

  echo $data_all;

  $sms = new thsms();

  $sms->username   = 'mynamejesfz';
  $sms->password   = 'bba469';

  $a = $sms->getCredit();

  $sms->send( 'VIP', $customer_tel, trim($data_all));
  if($customer_tel !== '0836642021'){
    $sms->send( 'VIP', '0836642021', trim($data_all));
  }

  break;

  case 'insert_hum_number':

  // session_destroy(); die(); unset($_COOKIE);
  // $number = $data->queryResult->outputContexts[0]->parameters->hum_number;
  //
  // $sql = mysqli_query($dbc, "INSERT INTO LineAPI VALUES (NULL, '$userId', '$number', NULL)");
  //
  // $res = mysqli_query($dbc, "SELECT * FROM LineAPI WHERE User_id = '$userId'");
  // $dis_number = '';
  // $i = 0;
  // while($result = mysqli_fetch_assoc($res)){
  //   $i++;
  //   if($i == 1){ $dis_number .= $result['Number']; }else{ $dis_number .= ', '.$result['Number']; }
  // }

  die();
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.line.me/v2/bot/message/push",
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\n   \"to\":\"$userId\",\n   \"messages\":[\n   {\n  \"type\": \"text\",\n  \"text\": \"SESSION ID: $ses_id\\nUSER ID: $userId\\nSTATUS: $statnm\"\n}\n   ]\n}",
    CURLOPT_HTTPHEADER => array(
      "authorization: Bearer sWgpfw4w11QeoHoA78HESv1oajCUv4X5BRNl3FtG38/23k2GVEFF5cvnPX89WzwPO1MRiW0LCGtDCGQmfoTW08SKNVE2sg+yvRTapIJkFLeb3rCpXgLeWXni06bjUaReKmI816JBR0PjhM0Dv3mNTgdB04t89/1O/w1cDnyilFU=",
      "cache-control: no-cache",
      "content-type: application/json",
      "postman-token: 7f766920-b207-53c4-6059-6d20ceec77ea",
    ) ,
  ));
  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  if ($err){
  echo "cURL Error #:" . $err;
  }
  else
  {
  echo '<pre>'.print_r(json_decode($response), true).'</pre>';
  }


  break;

  default:
    // code...
    break;
}
?>
