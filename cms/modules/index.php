<?php
/************************************************************************
 * The script of company catalogue EMPRESA
 * Copyright (c) 2017 - 2019 Kamil Wyremski
 * http://wyremski.pl
 * kamil.wyremski@gmail.com
 * 
 * All right reserved
 * 
 * *********************************************************************
 * THIS SOFTWARE IS LICENSED - YOU CAN MODIFY THESE FILES
 * BUT YOU CAN NOT REMOVE OF ORIGINAL COMMENTS!
 * ACCORDING TO THE LICENSE YOU CAN USE THE SCRIPT ON ONE DOMAIN. DETECTION
 * COPY SCRIPT WILL RESULT IN A HIGH FINANSIAL PENALTY AND WITHDRAWAL
 * LICENSE THE SCRIPT
 * *********************************************************************/
 
if(!isset($settings['base_url'])){
	die('Access denied!');
}

if(isset($_POST['action']) and $_POST['action'] == 'login' and isset($_POST['session_code']) and $_POST['session_code']!='' and isset($_POST['username']) and $_POST['username']!='' and isset($_POST['password']) and $_POST['password']!=''){
	$user_cms->login($_POST);
}

if(!$user_cms->logged_in){
	$smarty->assign("session_code", $user_cms->newSessionCode());
}

if($user_cms->error){
	$smarty->assign('error',$user_cms->error);
}

?>