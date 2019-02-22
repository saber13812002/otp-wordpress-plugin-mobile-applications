<?php
$i = 1;
// echo '1:'.$i++;
include 'Telegram2.php';
//include 'Pushe2.php';
//include 'Slack2.php';
//slack("hi");
$errorNeedPushePhone = array('msg' => "error please send pusheid and phone 09196070718 as quesrystring for me");
$errorBadNumber = array('msg' => "error please send pusheid as quesrystring for me");
$errorPhoneNumberLength = array('msg' => "mobile phone number length (number of digits) should greater that 10");
$success = array('status' => 200, 'msg' => "ok");

$pushe_id = $_REQUEST['pusheid'];
$recipient_no = $_REQUEST['phone'];
$len = strlen($recipient_no);

if ($len >= 10) {

    $recipient_no = substr($recipient_no, $len - 10, $len);

    // require_once __DIR__ . '/db_connect.php';
    // $sql = new DB();

    // Load and initialize database class
    require_once 'db.class.php';
    $db = new DB();

    if ($pushe_id) {
        if ($recipient_no) {
            // Generate random verification code
            $rand_no = rand(10000, 99999);

            // Check previous entry
            $conditions = array(
                'mobile_number' => $recipient_no,
            );

            $checkPrev = $db->checkRow($conditions);

            $insert=-1;
            // Insert or update otp in the database
            if ($checkPrev) {
                $otpData = array(
                    'verification_code' => $rand_no,
                );
                $insert = $db->update($otpData, $conditions);
            } else {
                $otpData = array(
                    'mobile_number' => $recipient_no,
                    'verification_code' => $rand_no,
                    'verified' => 0,
                );
                $insert = $db->insert($otpData,"bb_players");
            }
            //echo $insert;
            if ($insert!=-1) {
                // Send otp to user via SMS

                $message = 'Dear User, OTP for mobile number ' . $recipient_no . 'verification is ' . $rand_no . '. Thanks berimbasket.ir';
                $sent = sendSMS($recipient_no, $rand_no);
                //slack($message);
                if ($sent) {
                    $otpDisplay = 1;
                    echo json_encode($success);
                    if(get_option('is_telegram_log_enabled')=="1")
                    sendMsg($rand_no . "
pusheid: $pushe_id
phone: $recipient_no");

                } else {
                    $statusMsg = array(
                        'status' => 'error',
                        'msg' => "We're facing some issue on sending SMS, please try again.",
                    );
                }

            } else {
                $statusMsg = array(
                    'status' => 'error',
                    'msg' => 'Some problem occurred, please try again.',
                );
            }
        } else {
            $statusMsg = array(
                'status' => 'error',
                'msg' => 'Please enter your mobile number.',
            );
        }
    } else {
        echo json_encode($error);
    }
} else {
    echo json_encode($errorBadNumber);

}

function sendMsg($message)
{
    $bot_id = "369147560:AAEVq707XPH_nH3pTl1kMNLKPhkyQWsmUCA";
    $telegram = new Telegram($bot_id);
    $chat_id = -1001136444717;
    $content = array('chat_id' => $chat_id, 'text' => $message);
    $telegram->sendMessage($content);
}

function sendSMS($recipient_no, $rand_no)
{
    $curl = curl_init();
    //echo $recipient_no;echo $rand_no;
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.kavenegar.com/v1/4F6A4449587362356C7538614F6A7954535475695A513D3D/verify/lookup.jso",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"receptor\"\r\n\r\n" . $recipient_no . "\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"token\"\r\n\r\n" . $rand_no . "\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"template\"\r\n\r\nBerimBasketVerificationCode\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"type\"\r\n\r\nsms\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
            "postman-token: c19618a1-fe23-69ea-de69-be1eedc13cfe",
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    //$err = false;

    curl_close($curl);

    if ($err) {
        //echo "cURL Error #:" . $err;
        //TODO: send error or  log or telegram or email or all
        return false;
    } else {
        //echo $response;
        //TODO: send error or  log or telegram or email or all
        return true;
    }
}
