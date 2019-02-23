<?php
require_once(dirname(__FILE__) . '/../../../wp-includes/pluggable.php');
//require __DIR__.'/vendor/autoload.php';
//use \Firebase\JWT\JWT;

include 'number.php';
// include 'Telegram2.php';
require_once('../../../wp-load.php');
//require_once '../../../wp-config.php';
require_once('../../../wp-admin/includes/user.php' );

if (isset($_REQUEST['phone']) && isset($_REQUEST['code'])) 
{
    $pushe_id = $_REQUEST['pusheid'];

    $phone=$_REQUEST['phone'];
    $code=$_REQUEST['code'];

    require_once 'db.class.php';
    $db = new DB();


    $errorBadNumber = array('status' => 300,'msg' => "error please send pusheid as quesrystring for me");
    $errorCodeNumber = array('status' => 303,'msg' => "error code incorrect try again!");
    
    $len = strlen($phone);
    if ($len >= 10) {
        $phone =  right10($phone);
        $mobileregex = "/^[6-9][0-9]{9}$/";
        $conditions = array(
            'mobile_number' => $phone,
            'verification_code' => $code,
        );
    //echo $code;
        $checkPrev = $db->checkRow($conditions);
        if (!$checkPrev) {
            echo json_encode($errorCodeNumber);
    //         sendTelegeramMsg("user not created! error
    //  pusheid: $pushe_id
    //  code: $code
    // phone: $phone");
        } else {
            $otpData = array(
                'verified' => 1,
            );
            $update = $db->update($otpData, $conditions);
    
            $username="user_".MD5($phone);
            //$password=getToken();
            $password=MD5($code);

            //generate_token($username, $password, "2345-2345-2345-2345-2345");
            $email=$username."@berimbasket.ir";
            //echo $username ." ". $password ." ". $email;

            
            $tbl="vb_user";

            $conditions = array(
                'cellphone' => "0".$phone
            );
//exist or not        
            $checkUserExistOrnot = $db->checkRowInThisTable($conditions,$tbl);

            if($checkUserExistOrnot)
            {
                //get token sent
                $conditions = array(
                    'cellphone' => "0".$phone
                );
                $token = $db->getColVal($tbl , 'password',$conditions);
                $success = array(
                    'status' => 200,
                    'id' => $update_id,
                    'msg' => "ok",
                    'token' => $token,
                    'user_email' => $username,
                    'user_nicename' => $username,
                    'user_display_name' => $username);
                echo json_encode($success);
            }
            else{
            
                $data = array(
                    'username' => $username,
                    'code' => $code,
                    'cellphone' => "0".$phone,
                    'password' => $password,
                );
                $update_id = $db->insert($data,$tbl);

                if($update_id>0)
                {
                    $user_id=wp_create_user($username,$password,$email);
                    // $user_id = wp_update_user( array( 
                    //     'ID' => $user_id, 
                    //     'bb_id' => $update_id, 
                    //     'first_name' => $userProp->firstNameField, 
                    //     'last_name' => $userProp->lastNameField, 
                    //     'display_name' => $userProp->firstNameField." ".$userProp->lastNameField, 
                    //     'nickname' => $userProp->firstNameField." ".$userProp->lastNameField ) );
                    $updated = update_user_meta( $user_id, 'bb_id', $update_id );
                    $user = wp_authenticate($username, $password);
            
                    // sendTelegeramMsg("user not created! error
                    // pusheid: $pushe_id
                    // code: $code
                    // phone: $phone
                    // ".$e->getMessage());
                    
                    $msg="user created!
                    pusheid: $pushe_id
                    code: $code
                    phone: $phone";
                    // sendTelegeramMsg($msg);
                    //slack($msg);


                    $success = array(
                        'status' => 200,
                        'id' => $update_id,
                        'msg' => "ok",
                        'token' => $password,
                        'user_email' => $username,
                        'user_nicename' => $username,
                        'user_display_name' => $username);
                    echo json_encode($success);
                }
                else{
                    $success = array(
                        'status' => 500,
                        'id' => $update_id,
                        'msg' => "error! user exist or table not found",
                        'token' => $password,
                        'user_email' => $username,
                        'user_nicename' => $username,
                        'user_display_name' => $username);
                    echo json_encode($success);
                }
            }
        }

        // $jwt="asdfasdfasdfasdf";
        // $success=array("jwt"=>"$jwt");
        // echo json_encode($success);
    }
} else {
    echo json_encode($errorBadNumber);
}



function generate_token($username, $password)
{
    $secret_key = defined('JWT_AUTH_SECRET_KEY') ? JWT_AUTH_SECRET_KEY : false;
    $user = wp_authenticate($username, $password);

    $issuedAt = time();
    $notBefore = apply_filters('jwt_auth_not_before', $issuedAt, $issuedAt);
    $expire = apply_filters('jwt_auth_expire', $issuedAt + (DAY_IN_SECONDS * 730), $issuedAt);

    $token = array(
        'iss' => get_bloginfo('url'),
        'iat' => $issuedAt,
        'nbf' => $notBefore,
        'exp' => $expire,
        'data' => array(
            'user' => array(
                'id' => $user->data->ID,
            ),
        ),
    );

    return JWT::encode($token, $secret_key);
}

function getToken()
{
 $curl = curl_init();   
 curl_setopt_array($curl, array(
     CURLOPT_URL => "https://WWW.QQQ.ir/api/Core/AuthenticationRequest",   
     CURLOPT_RETURNTRANSFER => true,   
     CURLOPT_HEADER => true,   
     CURLOPT_ENCODING => "",   
     CURLOPT_MAXREDIRS => 10,   
     CURLOPT_TIMEOUT => 30,   
     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,   
     CURLOPT_SSL_VERIFYHOST => 0,   
     CURLOPT_SSL_VERIFYPEER => 0,   
     CURLOPT_CUSTOMREQUEST => "POST",   
     CURLOPT_HTTPHEADER => array(   
         "content-type: application/json"   
     , 'Content-Length: 0'   
     ),   
 ));   
 $response = curl_exec($curl);   
 $err = curl_error($curl);   
 curl_close($curl);   
 if ($err) {   
     //echo "cURL Error #:" . $err;   
 } else {   
     $res = extract_curl($response, true);   
     $challenge = $res->Headers['X-Challenge'];
     $token = $res->Body;  
     return $token;
 }
}