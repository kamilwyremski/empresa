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

if(!empty($_GET['slug'])){
	$profile = $user->getProfile($_GET['slug']);

	if($profile){
		$settings['seo_title'] = lang('Profile of').': '.$profile['username'].' - '.$settings['title'];
		$settings['seo_description'] = lang('Profile of').': '.$profile['username'].' - '.$settings['description'];
		$smarty->assign('profile',$profile);
		
		if(isset($_POST['action']) and $_POST['action']=='send_message' and isset($_POST['name']) and isset($_POST['email']) and isset($_POST['message']) and isset($_POST['captcha'])){

		if($_POST['captcha']!=$_SESSION['captcha']){
			$error['captcha'] = lang('Invalid captcha code.');
		}else{
			if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
				$error['email'] = lang('Incorrect e-mail address.');
			}
			if($_POST['name']==''){
				$error['name'] = lang('Enter your name');
			}
			if($_POST['message']==''){
				$error['message'] = lang('Enter your message');
			}
			if(!isset($_POST['rules'])){
				$error['rules'] = lang('This field is mandatory.');
			}
		}
		
		if(isset($error)){
			$error['alert'] = lang('The message was not sent');
			$smarty->assign("error", $error);
			$smarty->assign("input", array('name'=>$_POST['name'], 'email'=>$_POST['email'], 'message'=>$_POST['message']));
		}else{
			
			if(send_mail('profile',$profile['email'],array('name'=>$_POST['name'], 'email'=>$_POST['email'], 'message'=>$_POST['message'], 'username'=>$profile['username']))){
				$smarty->assign("info", lang('The message was correctly sent'));
			}else{
				$error['alert'] = lang('The message was not sent');
				$smarty->assign("error", $error);
			}
		}
	}
	}else{
		include('model/404.php');
	}
}else{
	include('model/404.php');
}

?>