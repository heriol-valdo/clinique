<?php
/**
 * Created by PhpStorm.
 * User: Poizon
 * Date: 27/07/2015
 * Time: 12:12
 */

namespace Projet\Model;


use Nexmo\Client;
use Nexmo\Client\Credentials\Basic;

class Sms {
    private static $leLogin = 'AFRIKFEED';
    private static $lePass = 'cwshl7DHSz@';
    private static $user = 'ndjendje2019';
    private static $code = 'esm58295';
    private static $login = 'SESAME';
    private static $password = 'SES@M3!96';
    private static $NEXMO_API_KEY = '9e9264f4';
    private static $NEXMO_API_SECRET = '65916e6005effb30';

    private static $username = 'afrik.fid018';
    private static $pass = 'web14505';

    public static function sendSms($number,$message,$sender){
        $message = urlencode(str_replace('\n','.',$message));
        //$url = 'https://sms.etech-keys.com/ss/api.php?login='.self::$login.'&password='.self::$password.'&sender_id='.$sender.'&destinataire='.$number.'&message='.$message;
        //$url = 'http://lmtgroup.dyndns.org/sendsms/sendsmsGold.php?UserName='.self::$login.'&Password='.self::$password.'&SOA='.$sender.'&MN='.self::getPhone($number).'&SM='.$message;
        //$url = 'https://api.1s2u.io/bulksms?username='.self::$username.'&password='.self::$pass.'&mt=0&fl=0&sid='.$sender.'&mno='.$number.'&ipcl='.$_SERVER['REMOTE_ADDR'].'&msg='.$message;
        //$url = 'https://www.easysendsms.com/sms/bulksms-api/bulksms-api?username='.self::$user.'&password='.self::$code.'&from='.$sender.'&to='.$number.'&text='.$message.'&type=0';
        $url = 'https://lampush-tls.lafricamobile.com/api?accountid='.self::$leLogin.'&password='.self::$lePass.'&text='.$message.'&to=+'.$number.'&sender='.$sender;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $return = curl_exec($ch);
        curl_close($ch);
        return $return;
        /*$basic  = new Basic(self::$NEXMO_API_KEY,self::$NEXMO_API_SECRET);
        $client = new Client($basic);
        try{
            return $client->message()->send([
                'to' => $number,
                'from' => $sender,
                'text' => $message
            ]);
        }catch (\Exception $e){ return false; }*/

    }

    public static function resultSms($number,$message,$sender){
        return self::sendSms($number,$message,$sender);
    }

    public static function getPhone($number){
        $code = substr($number,0,3);
        if($code=='237'){
            $result = substr($number,3);
        }else{
            $result = $number;
        }
        return $result;
    }
    /*
     * https://sms.etech-keys.com/ss/api.php?login=693381374&password=BRIDGE&sender_id=ERROR&destinataire=693381374&message=bjrtest
     */

}