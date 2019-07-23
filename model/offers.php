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

$offers = new offer;
$offers->loadOffers($settings['limit_page']);

get_offers_categories();

get_offers_state();

if($settings['search_box_options']){
	$offers_options = new offers_options;
	$offers_options->getOptions(true);
}

$settings['seo_title'] = lang('Offers - search results').' - '.$settings['title'];
$settings['seo_description'] = lang('Offers - search results').' - '.$settings['description'];

