<?php
/************************************************************************
 * The script of company catalogue EMPRESA
 * Copyright (c) 2017 - 2019 Kamil Wyremski
 * http://wyremski.pl
 * kamil.wyremski@gmail.com
 * 
 * All right reserved
 * 
*/
 
if(!isset($settings['base_url'])){
	die('Access denied!');
}

require_once(realpath(dirname(__FILE__)).'/../libs/PHPMailer-master/PHPMailerAutoload.php');

$mail = new PHPMailer();
 
$mail->IsSMTP();        
$mail->CharSet = "utf-8";
$mail->From = $settings['smtp_mail']; 
$mail->FromName = $settings['title'];
$mail->Host = $settings['smtp_host'];  
$mail->Mailer = "smtp";
$mail->Username = $settings['smtp_user'];
$mail->Password = $settings['smtp_password'];
$mail->SMTPAuth = true;
$mail->Port = $settings['smtp_port']; 
$mail->SMTPSecure = $settings['smtp_secure']; 
$mail->IsHTML(true);

$mail->smtpConnect(
    array(
        "ssl" => array(
            "verify_peer" => false,
            "verify_peer_name" => false,
            "allow_self_signed" => true
        )
    )
);
 
