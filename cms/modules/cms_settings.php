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

if($user_cms->logged_in){

	if(!_CMS_TEST_MODE_ and isset($_POST['action'])){
		
		if($_POST['action'] == 'cms_change_user' and !empty($_POST['new_username']) and !empty($_POST['new_password']) and !empty($_POST['repeat_new_password'])){
			
			$user_cms->changeUser($_POST);
			
		}elseif($_POST['action'] == 'cms_remove_logs'){
			
			$user_cms->removeLogs();
			
		}elseif($_POST['action'] == 'cms_add_user' and !empty($_POST['username']) and !empty($_POST['password']) and !empty($_POST['repeat_password'])){
			
			$user_cms->addUser($_POST);
			
		}elseif($_POST['action'] == 'cms_remove_user' and isset($_POST['id']) and $_POST['id']>0){
			
			$user_cms->removeUser($_POST['id']);
			
		}elseif($_POST['action'] == 'cms_logout_all'){
			
			$user_cms->logOutAll();
			
		}
		
	}
	
	if($user_cms->info){
		$smarty->assign('info',$user_cms->info);
	}elseif($user_cms->error){
		$smarty->assign('error',$user_cms->error);
	}

	$smarty->assign("cms_users", $user_cms->getUsers());
	$smarty->assign("cms_logs", $user_cms->getLogs());
	
	$title = lang('Settings CMS').' - '.$title_default;

}

?>