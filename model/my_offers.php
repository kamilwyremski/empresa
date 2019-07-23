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

if($user->logged_in){
	$offers = new offer;
	$offers->loadOffers($settings['limit_page'],'my_offers');

	get_offers_categories();
	
	get_offers_state();
	
	$settings['seo_title'] = lang('My offers').' - '.$settings['title'];
	$settings['seo_description'] = lang('My offers').' - '.$settings['description'];
	
}else{
	header("Location: ".$settings['base_url']."/".$links['login']."?redirect=".$links['my_offers']);
	die('redirect');
}



?>