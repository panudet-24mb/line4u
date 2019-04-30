<?php
// กรณีต้องการตรวจสอบการแจ้ง error ให้เปิด 3 บรรทัดล่างนี้ให้ทำงาน กรณีไม่ ให้ comment ปิดไป
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
header('Content-Type: text/html; charset=utf-8');

// include composer autoload
require_once 'vendor/autoload.php';

// การตั้งเกี่ยวกับ bot
require_once 'Api_Setting.php';

// กรณีมีการเชื่อมต่อกับฐานข้อมูล
//require_once("dbconnect.php");

///////////// ส่วนของการเรียกใช้งาน class ผ่าน namespace
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
//use LINE\LINEBot\Event;
//use LINE\LINEBot\Event\BaseEvent;
//use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\LocationMessageBuilder;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
use LINE\LINEBot\ImagemapActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder ;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\DatetimePickerTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder;

// เชื่อมต่อกับ LINE Messaging API
$httpClient = new CurlHTTPClient(LINE_MESSAGE_ACCESS_TOKEN);
$bot = new LINEBot($httpClient, array('channelSecret' => LINE_MESSAGE_CHANNEL_SECRET));


// คำสั่งรอรับการส่งค่ามาของ LINE Messaging API
$content = file_get_contents('php://input');

if(!empty($content)){
  $fp = fopen('results.json', 'w');
  fwrite($fp, $content);
  fclose($fp);
}

$json_url = "https://pnall.co.th/apps/line/pm2019/Line/results.json";
$json = file_get_contents($json_url);

$data = json_decode($json);

// echo '<pre>'.print_r($data, true).'</pre>';

// echo 'NiSKx:'.'<pre>'.print_r($data->events[0]->source->userId, true).'</pre>';

$userId = $data->events[0]->source->userId;

// แปลงข้อความรูปแบบ JSON  ให้อยู่ในโครงสร้างตัวแปร array
$events = json_decode($content, true);
if(!is_null($events)){
     // ถ้ามีค่า สร้างตัวแปรเก็บ replyToken ไว้ใช้งาน
    $replyToken = $events['events'][0]['replyToken'];
    $typeMessage = $events['events'][0]['message']['type'];
    $userMessage = $events['events'][0]['message']['text'];



}


// บัคๆอยู่เดี้ยวมาแก้  --------------------- เอาไว้ทดสอบ DB เล่นๆ ถ้าไม่ลืม แก้ ก็ลบออกด้วย เดี้ยวลืม



//--/


$date = date("Y-m-d H:i:s");
$serverName = "localhost";
$userName = "root";
$userPassword = "P@ssw0rd";
$dbName = "PM2019";


$conn = mysqli_connect($serverName,$userName,$userPassword,$dbName);
$sql = mysqli_query($conn, "SELECT * FROM user WHERE user_lineid = '$userID'");
$numm = mysqli_num_rows($sql);
if($numm >= 1){

 echo "mai dai ja ";

}else{

echo "test";

}




$serverName = "localhost";
       $userName = "root";
       $userPassword = "P@ssw0rd";
       $dbName = "PM2019";
       $conn = mysqli_connect($serverName,$userName,$userPassword,$dbName);
       $sql = mysqli_query($conn,"SELECT * FROM user WHERE user_lineid = '$userID' AND user_isactive = '1'");

       if ($sql){
        print_r($sql);
       }else{
                    echo "not";
       }






// บัคๆอยู่เดี้ยวมาแก้  --------------------- เอาไว้ทดสอบ DB เล่นๆ ถ้าไม่ลืม แก้ ก็ลบออกด้วย เดี้ยวลืม


// บัคๆอยู่เดี้ยวมาแก้


if(!is_null($events)){
    // ถ้ามีค่า สร้างตัวแปรเก็บ replyToken ไว้ใช้งาน
    $replyToken = $events['events'][0]['replyToken'];
    $userID = $events['events'][0]['source']['userId'];
    $sourceType = $events['events'][0]['source']['type'];
    $is_postback = NULL;
    $is_message = NULL;
    if(isset($events['events'][0]) && array_key_exists('message',$events['events'][0])){
        $is_message = true;
        $typeMessage = $events['events'][0]['message']['type'];
        $userMessage = $events['events'][0]['message']['text'];
        $idMessage = $events['events'][0]['message']['id'];
    }
    if(isset($events['events'][0]) && array_key_exists('postback',$events['events'][0])){
        $is_postback = true;
        $dataPostback = NULL;
        parse_str($events['events'][0]['postback']['data'],$dataPostback);;
        $paramPostback = NULL;
        if(array_key_exists('params',$events['events'][0]['postback'])){
            if(array_key_exists('date',$events['events'][0]['postback']['params'])){
                $paramPostback = $events['events'][0]['postback']['params']['date'];
            }
            if(array_key_exists('time',$events['events'][0]['postback']['params'])){
                $paramPostback = $events['events'][0]['postback']['params']['time'];
            }
            if(array_key_exists('datetime',$events['events'][0]['postback']['params'])){
                $paramPostback = $events['events'][0]['postback']['params']['datetime'];
            }
        }
    }
    if(!is_null($is_postback)){
        $textReplyMessage = "ข้อความจาก Postback Event Data = ";
        if(is_array($dataPostback)){
            $textReplyMessage.= json_encode($dataPostback);
        }
        if(!is_null($paramPostback)){
            $textReplyMessage.= " \r\nParams = ".$paramPostback;
        }
        $replyData = new TextMessageBuilder($textReplyMessage);
    }
    if(!is_null($is_message)){
        switch ($typeMessage){
            case 'text':
                $userMessage = strtolower($userMessage); // แปลงเป็นตัวเล็ก สำหรับทดสอบ

       ///-------------------------------ตรวจสอบ is active --------------------//


       $serverName = "localhost";
       $userName = "root";
       $userPassword = "P@ssw0rd";
       $dbName = "PM2019";
       $conn = mysqli_connect($serverName,$userName,$userPassword,$dbName);

       $sql = "SELECT * FROM user WHERE user_lineid = '$userID' AND user_isactive = 1 " ;

       $query = mysqli_query($conn,$sql);

















                switch ($userMessage) {
                    case "p":
                    // เรียกดูข้อมูลโพรไฟล์ของ Line user โดยส่งค่า userID ของผู้ใช้ LINE ไปดึงข้อมูล
                    $response = $bot->getProfile($userID);
                    if ($response->isSucceeded()) {
                        // ดึงค่ามาแบบเป็น JSON String โดยใช้คำสั่ง getRawBody() กรณีเป้นข้อความ text
                        $textReplyMessage = $response->getRawBody(); // return string
                        $replyData = new TextMessageBuilder($textReplyMessage);
                        break;
                    }
                    // กรณีไม่สามารถดึงข้อมูลได้ ให้แสดงสถานะ และข้อมูลแจ้ง ถ้าไม่ต้องการแจ้งก็ปิดส่วนนี้ไปก็ได้
                    $failMessage = json_encode($response->getHTTPStatus() . ' ' . $response->getRawBody());
                    $replyData = new TextMessageBuilder($failMessage);
                    break;

                    //case study

                    case "check-in" :

                    // เรียกดูข้อมูลโพรไฟล์ของ Line user โดยส่งค่า userID ของผู้ใช้ LINE ไปดึงข้อมูล
                    $response = $bot->getProfile($userID);
                    if ($response->isSucceeded()) {
                        // ดึงค่าโดยแปลจาก JSON String .ให้อยู่ใรูปแบบโครงสร้าง ตัวแปร array
                        $userData = $response->getJSONDecodedBody(); // return array
                        // $userData['userId']
                        // $userData['displayName']
                        // $userData['pictureUrl']
                        // $userData['statusMessage']

                    $replyData = new TemplateMessageBuilder('Confirm Template',
                        new ConfirmTemplateBuilder(
                                'ลงทะเบียนแล้วหรือยัง?',

                               array(
                                     new MessageTemplateActionBuilder(
                                       'HQ',
                                       'ยืนยัน'


                                   ),
                                    new MessageTemplateActionBuilder(
                                       'ยกเลิก',
                                        'NO'
                                   )
                                )

                        )

                    );
                }
               break;

            case "ยืนยัน":

            // เรียกดูข้อมูลโพรไฟล์ของ Line user โดยส่งค่า userID ของผู้ใช้ LINE ไปดึงข้อมูล
            $response = $bot->getProfile($userID);
            if ($response->isSucceeded()) {
                // ดึงค่าโดยแปลจาก JSON String .ให้อยู่ใรูปแบบโครงสร้าง ตัวแปร array
                $userData = $response->getJSONDecodedBody(); // return array
                // $userData['userId']
                // $userData['displayName']
                // $userData['pictureUrl']
                // $userData['statusMessage']
                $textReplyMessage = 'สวัสดีครับ คุณ '.$userData['displayName'] .'กรุณาพิมพ์ #! และ ตามด้วย รหัส SET ';
                $replyData = new TextMessageBuilder($textReplyMessage);
                break;
            }





                    //module หลัก TEST


                    case "stulog":
                    $serverName = "localhost";
                    $userName = "root";
                    $userPassword = "P@ssw0rd";
                    $dbName = "PM2019";

                   $conn = mysqli_connect($serverName,$userName,$userPassword,$dbName);

                   $sql = "SELECT * FROM user WHERE user_id=1" ;

                   $query = mysqli_query($conn,$sql);
                   $res = mysqli_fetch_array($query);
                   $textReplyMessage = "";
                   if($query){
                    $textReplyMessage = "Username:".$res['user_username']."\nUser Date:".$res['user_datetime'];
                  }else{
                    $textReplyMessage = "เชื่อมต่อไม่สำเร็จ";
                  }
                   $replyData = new TextMessageBuilder($textReplyMessage);
                   break;



                   case 'register' :

                   $response = $bot->getProfile($userID);
                   $userData = $response->getJSONDecodedBody();

                   $date = date("Y-m-d H:i:s");
                   $serverName = "localhost";
                   $userName = "root";
                   $userPassword = "P@ssw0rd";
                   $dbName = "PM2019";


                  $conn = mysqli_connect($serverName,$userName,$userPassword,$dbName);
                  $sql = mysqli_query($conn, "SELECT * FROM user WHERE user_lineid = '$userID'");
                  $numm = mysqli_num_rows($sql);
                  if($numm >= 1){

                    echo "mai dai ja ";

                  }else{


                  $query = mysqli_query($conn,$sql);
                  $res = mysqli_fetch_array($query);
                  $textReplyMessage = "";
				  $username2 = $userData['displayName'] ;
				  $userpicture = $userData['pictureUrl'];

                  $sql = mysqli_query($conn, "INSERT INTO user VALUES(NULL, 'username', 'password', '$userID', '$username2', 'lastname', 'Device', 'lat', 'logtitude', '$date', 'companycode','$userpicture','0','0')");

                   $textReplyMessage = "ลงทะเบียนมือถือกับระบบ PM2019 เรียบร้อย ครับ :    คุณ ".$userData['displayName']."\n";

                  $replyData = new TextMessageBuilder($textReplyMessage);
                  break;


                }

                break;







                  case "testเงื่อนไขในการตรวจสอบisactive":

                    $serverName = "localhost";
                    $userName = "root";
                    $userPassword = "P@ssw0rd";
                    $dbName = "PM2019";
                    $conn = mysqli_connect($serverName,$userName,$userPassword,$dbName);

                    $sql = "SELECT * FROM user WHERE user_lineid = '$userID' AND user_isactive = 1 " ;

                    $query = mysqli_query($conn,$sql);


                  break;


case "เกิดวันเสาร์":
						$textReplyMessage = "ดูดวงรายวันสำหรับท่านที่เกิดวันเสาร์ ประจำวันศุกร์ ที่ 2 พฤศจิกายน 2561\n\nการงาน: ด้วยความรู้ ความสามารถในการติดต่อเจรจากับผู้ใหญ่ จะทำให้เกิดความสำเร็จที่น่าพอใจ\n\nการเงิน: มีเรื่องที่ต้องใช้จ่ายออกไปมาก แต่ก็จะสามารถหมุนหาเข้ามาใช้จ่ายได้เพิ่มเติมมากขึ้น\n\nความรัก: มีเสน่ห์มากๆ ในช่วงนี้ จึงมีคนอยากเข้ามาทักทาย ทำความรู้จักด้วย\n\nอัญมณีมงคล: ทับทิม\n\nสีมงคล: แดง\n\nเลขนำโชค: 1,2,3,6,9";
						$replyData = new TextMessageBuilder($textReplyMessage);
					break;
					

					case "เกิดวันอาทิตย์":
						$textReplyMessage = "ดูดวงรายวันสำหรับท่านที่เกิดวันอาทิตย์ ประจำวันศุกร์ ที่ 2 พฤศจิกายน 2561\n\nการงาน: การเจรจา การตัดสินใจจะประสบความสำเร็จ ประสบความโชคดี ประสบความก้าวหน้าที่ดี\n\nการเงิน: ประสบความล่าช้าทางด้านการเงิน แต่สุดท้ายก็จะสามารถหาเข้ามาได้เพิ่มเติมเพิ่มมากขึ้น\n\nความรัก: โดยภาพรวม ความสัมพันธ์ด้านความรักก็ถือว่าลงตัว อยู่ในเกณฑ์ที่ดี\n\nอัญมณีมงคล: ไข่มุก\n\nสีมงคล: ขาว\n\nเลขนำโชค: 2,5,7,9";
						$replyData = new TextMessageBuilder($textReplyMessage);
					break;

					case "เกิดวันจันทร์":
						$textReplyMessage = "ดูดวงรายวันสำหรับท่านที่เกิดวันจันทร์ ประจำวันศุกร์ ที่ 2 พฤศจิกายน 2561\n\nการงาน: การติดต่อ การประสานงานต่างๆ จะประสบความสำเร็จอยู่ในเกณฑ์ที่ดี\n\nการเงิน: หามาได้ก็เก็บเงินไม่อยู่ หามาได้ก็ต้องใช้จ่ายออกไป เป็นการหมุนเงินให้ผ่านพ้นไปได้\n\nความรัก: สุขสมหวังด้านความรัก มีโอกาสพัฒนาความสัมพันธ์  ความรักอยู่ในเกณฑ์ที่ดีมากๆ\n\nอัญมณีมงคล: พลอยสีชมพู\n\nสีมงคล: ชมพู\n\nเลขนำโชค: 1,5,6";
						$replyData = new TextMessageBuilder($textReplyMessage);
					break;

					case "เกิดวันอังคาร":
						$textReplyMessage = "ดูดวงรายวันสำหรับท่านที่เกิดวันอังคาร ประจำวันศุกร์ ที่ 2 พฤศจิกายน 2561\n\nการงาน: ประสบความสำเร็จทางด้านการงานดีขึ้น การเจรจาต่อรองประสบความสำเร็จได้ดีขึ้นไปอีก\n\nการเงิน: หามาได้มากก็จะใช้จ่ายออกไปมาก ในช่วงนี้ไม่สามารถเก็บเงินได้ดีเท่าไรนัก\n\nความรัก: ยังไม่ตัดสินใจด้านความรัก หรือจะพบเจอเหตุการณ์ที่ทำให้เกิดความเหินห่างระหว่างกัน\n\nอัญมณีมงคล: ไพลิน\n\nสีมงคล: น้ำเงิน\n\nเลขนำโชค: 3,5,6,7";
						$replyData = new TextMessageBuilder($textReplyMessage);
					break;

					case "เกิดวันพุธ":
						$textReplyMessage = "ดูดวงรายวันสำหรับท่านที่เกิดวันพุธ ประจำวันศุกร์ ที่ 2 พฤศจิกายน 2561\n\nการงาน: จะทำงานใดๆ จะประสบความสำเร็จ และจะพบเจอความโชคดีไปทุกอย่าง ทำอะไรก็สำเร็จ\n\nการเงิน: โชคดี มีโชคจะได้เงินเข้ามาเพิ่มเติมมากขึ้นก็เป็นไปได้ เพราะจะพบผู้อุปถัมภ์ทางด้านการเงิน\n\nความรัก: ความสัมพันธ์ทางด้านความรักค่อยๆ ดีขึ้น ก็เพราะแบ่งเวลาให้กับคนรักได้มากขึ้น\n\nอัญมณีมงคล: หยก\n\nสีมงคล:  เขียว\n\nเลขนำโชค: 1,2,5,7,9";
						$replyData = new TextMessageBuilder($textReplyMessage);
					break;

					case "เกิดวันพฤหัสฯ":
						$textReplyMessage = "ดูดวงรายวันสำหรับท่านที่เกิดวันพฤหัสบดี ประจำวันศุกร์ ที่ 2 พฤศจิกายน 2561\n\nการงาน: การเจรจาต่อรองทางด้านการงานเกิดความโชคดี และความสำเร็จที่น่าพอใจ\n\nการเงิน: ระวังการใช้จ่ายเงินให้ดี ยังประมาทในเรื่องของการใช้จ่ายไม่ได้ และต้องประหยัดเข้าไว้\n\nความรัก: ระวังจะพบเรื่องความสัมพันธ์ที่ผิวเผิน เพราะจะเจอเรื่องที่ไม่ชัดเจนด้านความรัก\n\nอัญมณีมงคล: บุษราคัม\n\nสีมงคล: เหลือง\n\nเลขนำโชค: 4,6,8";
						$replyData = new TextMessageBuilder($textReplyMessage);
					break;

					case "เกิดวันศุกร์":
						$textReplyMessage = "ดูดวงรายวันสำหรับท่านที่เกิดวันศุกร์ ประจำวันศุกร์ ที่ 2 พฤศจิกายน 2561\n\nการงาน: ยังพิจารณาแผนงานอยู่ มีโอกาสเดินทางติดต่อหรือโยกย้ายด้านการงานบ่อยขึ้นมากๆ\n\nการเงิน: สามารถหาเข้ามาได้อย่างต่อเนื่อง ด้วยความขยันของตนเอง จะสามารถหาเงินเข้ามาได้อย่างเป็นโชคดี\n\nความรัก: ยังคงไม่แน่ใจในสถานการณ์ด้านความรัก ยังคงดูๆ อยู่มากกว่าที่จะตัดสินใจด้านความรัก\n\nอัญมณีมงคล: มรกต\n\nสีมงคล: เขียว\n\nเลขนำโชค: 0,1,6,7,8";
						$replyData = new TextMessageBuilder($textReplyMessage);
					break;





//API LIFF TEST v1

                    case "admin":
                    $textReplyMessage = 'line://app/1636902643-46LVNZPG';
                    $replyData = new TextMessageBuilder($textReplyMessage);
                    break;



                    case "check-out":
    // กำหนด action 4 ปุ่ม 4 ประเภท

    // $userData['statusMessage']
    $textReplyMessage = 'http://www.pn.in.th/demo/webupload';
    $replyData = new TextMessageBuilder($textReplyMessage);
    break;


                case "สวัสดี":
                    // เรียกดูข้อมูลโพรไฟล์ของ Line user โดยส่งค่า userID ของผู้ใช้ LINE ไปดึงข้อมูล
                    $response = $bot->getProfile($userID);
                    if ($response->isSucceeded()) {
                        // ดึงค่าโดยแปลจาก JSON String .ให้อยู่ใรูปแบบโครงสร้าง ตัวแปร array
                        $userData = $response->getJSONDecodedBody(); // return array
                        // $userData['userId']
                        // $userData['displayName']
                        // $userData['pictureUrl']
                        // $userData['statusMessage']
                        $textReplyMessage = 'สวัสดีครับ คุณ '.$userData['displayName'];
                        $replyData = new TextMessageBuilder($textReplyMessage);
                        break;
                    }
                    // กรณีไม่สามารถดึงข้อมูลได้ ให้แสดงสถานะ และข้อมูลแจ้ง ถ้าไม่ต้องการแจ้งก็ปิดส่วนนี้ไปก็ได้
                    $failMessage = json_encode($response->getHTTPStatus() . ' ' . $response->getRawBody());
                    $replyData = new TextMessageBuilder($failMessage);
                    break;
                default:
                    $textReplyMessage = " คุณไม่ได้พิมพ์ ค่า ตามที่กำหนด";
                    $replyData = new TextMessageBuilder($textReplyMessage);
                    break;
            }
            break;
				
		
            // update picture  --------------------------------- //

        case (preg_match('/[image|audio|video]/',$typeMessage) ? true : false) :

        $date = date("Y-m-d H:i:s");
        $serverName = "localhost";
        $userName = "root";
        $userPassword = "P@ssw0rd";
        $dbName = "PM2019";

            $response = $bot->getMessageContent($idMessage);
            if ($response->isSucceeded()) {





                // คำสั่ง getRawBody() ในกรณีนี้ จะได้ข้อมูลส่งกลับมาเป็น binary
                // เราสามารถเอาข้อมูลไปบันทึกเป็นไฟล์ได้
                $dataBinary = $response->getRawBody(); // return binary
                // ดึงข้อมูลประเภทของไฟล์ จาก header
                $fileType = $response->getHeader('Content-Type');
                switch ($fileType){
                    case (preg_match('/^image/',$fileType) ? true : false):

                $conn = mysqli_connect($serverName,$userName,$userPassword,$dbName);

                $sql = mysqli_query($conn,"UPDATE user SET user_isactive = '1' WHERE user_lineid = '$userID'");


	            $query = mysqli_query($conn,$sql);

	                        if($query) {
                                     echo "Record update successfully";

                                       }

	                                 mysqli_close($conn);


                        list($typeFile,$ext) = explode("/",$fileType);
                        $ext = ($ext=='jpeg' || $ext=='jpg')?"jpg":$ext;
                        $fileNameSave = time().".".$ext;
                        break;

                }
                $botDataFolder = 'temp/'; // โฟลเดอร์หลักที่จะบันทึกไฟล์
                $botDataUserFolder = $botDataFolder.$userID; // มีโฟลเดอร์ด้านในเป็น userId อีกขั้น
                if(!file_exists($botDataUserFolder)) { // ตรวจสอบถ้ายังไม่มีให้สร้างโฟลเดอร์ userId
                    mkdir($botDataUserFolder, 0777, true);
                }
               // กำหนด path ของไฟล์ที่จะบันทึก
                $fileFullSavePath = $botDataUserFolder.'/'.$fileNameSave;
                file_put_contents($fileFullSavePath,$dataBinary); // ทำการบันทึกไฟล์
                $textReplyMessage = "บันทึกไฟล์เรียบร้อยแล้ว กรุณากรอกชื่อไฟล์ให้ถูกต้อง $fileNameSave";
                $replyData = new TextMessageBuilder($textReplyMessage);
                break;





            }







            //test ระบบเฉยๆ
            $failMessage = json_encode($idMessage.' '.$response->getHTTPStatus() . ' ' . $response->getRawBody());
            $replyData = new TextMessageBuilder($failMessage);
            break;
        default:
            $textReplyMessage = json_encode($events);
            $replyData = new TextMessageBuilder($textReplyMessage);
            break;
    }
}
}
//l ส่วนของคำสั่งตอบกลับข้อความ
$response = $bot->replyMessage($replyToken,$replyData);

if ($response->isSucceeded()) {
    echo 'Succeeded!';
    return;
}

// Failed
echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
?>
