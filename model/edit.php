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

$page = 'add';
include('model/'.$page.'.php');
	
if(!empty($_GET['code'])){$code = $_GET['code'];}else{$code = '';}

if(isset($_GET['id']) and $_GET['id']>0 and $offer->checkPermissions($_GET['id'],$code)){
	$offer->loadOffer($_GET['id']);
	$settings['seo_title'] = lang('Edit offer').' - '.$settings['title'];
	$settings['seo_description'] = lang('Edit offer').' - '.$settings['description'];
}else{
	header("Location: ".$settings['base_url']."/".$links['add']);
	die('redirect');
}



?>