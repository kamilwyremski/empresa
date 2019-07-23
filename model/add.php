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

if($settings['add_offers_not_logged'] or $user->logged_in){
	
	$offer = new offer;
	
	if(!empty($_GET['code'])){$code = $_GET['code'];}else{$code = '';}

	if(isset($_POST['action']) and isset($_POST['name']) and $_POST['name']!='' and isset($_POST['email']) and $_POST['email']!='' and isset($_POST['session_code']) and $offer->checkSessionCode($_POST['session_code'])){
		if($_POST['action']=='add'){
			$offer->addOffer($_POST);
		}elseif($_POST['action']=='edit' and isset($_GET['id']) and $_GET['id']>0 and $offer->checkPermissions($_GET['id'],$code)){
			$offer->editOffer($_GET['id'],$_POST);
			$smarty->assign("info", lang('Your offer has been saved'));
		}
	}

	$offer->newSessionCode();
	
	get_offers_categories();
	get_offers_state();
	
	$offers_options = new offers_options;
	$offers_options->getOptions(true);
	
	$settings['seo_title'] = lang('Add offer').' - '.$settings['title'];
	$settings['seo_description'] = lang('Add offer').' - '.$settings['description'];
}else{
	header("Location: ".$settings['base_url']."/".$links['login']."?redirect=".$links['add']);
	die('redirect');
}



?>