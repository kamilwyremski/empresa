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
 
session_start(); 

require_once('../config/config.php');
include('user.class.php');
include('offer.class.php');

if(isset($_POST['action'])){
	if($_POST['action']=='get_coordinates' and $_POST['address'] and $_POST['address']!=''){
		echo json_encode(get_coordinates($_POST['address']));
	}elseif($_POST['action']=='remove_offer' and isset($_POST['id']) and $_POST['id']>0){
		$offer = new offer;
		if($offer->checkPermissions($_POST['id'],$_POST['code'])){
			$offer->remove($_POST['id']);
		}
	}
}else{
	die('Access denied!');
}
?>