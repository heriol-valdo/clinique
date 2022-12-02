<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 03/10/2016
 * Time: 18:34
 */

namespace Projet\Model;



use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Email {
    private $subject;
    private $body;
    private $sender;
    private $username = "noreply@afrikfid.boutique";
    private $password = "AFRIKFID00";
    private $port = 587;
    private $defaultName = "AFRIKFID";
    private $server = "mail.afrikfid.boutique";
    private $mail;

    private $template = "Templates/notif";
    private $viewPath ="Views/";

    function __construct($email,$subject,$receiverName,$name="AFRIKFID",$username="noreply@afrikfid.boutique",$password="AFRIKFID00"){
        try{
            $this->mail = new PHPMailer(true);
            $this->mail->isSMTP();
            $this->mail->isHTML();
            //$this->mail->CharSet = "text/html; charset=UTF-8;";
            $this->mail->CharSet = "UTF-8";
            $this->mail->ContentType = "text/html";
            $this->mail->setLanguage('fr', 'inc'.DIRECTORY_SEPARATOR.'PHPMailer');
            $this->mail->SMTPAuth = true;
            //$receiverName = '=?UTF-8?B?'.base64_encode($receiverName).'?=';
            $this->mail->SMTPDebug = 0;
            $this->mail->Host = $this->server;
            $this->mail->Port = $this->port;
            $this->mail->Username = $username;
            $this->mail->Password = $password;
            $this->mail->setFrom($username,$name);
            $this->mail->addAddress($email, $receiverName);
            $this->mail->Subject = $subject;
            //$this->mail->Subject = '=?UTF-8?B?'.base64_encode($subject).'?=';
            $template = $this->load('templates.notif',compact('email'));
            $this->mail->Body = $template;
            $this->mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
        }catch (Exception $e){}
    }

    public function load($view, $variables = []){
        ob_start();
        extract($variables);
        $page = explode('.',$view);
        require($this->viewPath .ucfirst($page[0]).'/'.$page[1].'.php');
        $content = ob_get_clean();
        return $content;

    }

    public function setFrom($address, $name="AFRIKFID"){
        $this->mail->setFrom($address, $name);
    }

    public function setSecure($bool){
        $this->mail->SMTPSecure = $bool;
    }

    public function setTo($address, $name=""){
        $this->mail->addAddress($address, $name);
    }
    public function setSubject($subject=""){
        $this->mail->Subject = $subject;
    }
    public function setBody($body, $datas = []){
        $template = $this->load($body,$datas);
        $this->mail->Body = $template;
    }

    public function send(){
        try{
            return $this->mail->send();
        }catch (Exception $e){return false;}
    }

}