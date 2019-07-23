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

header('Content-Type: text/html; charset=utf-8');

session_start(); 

require_once('../libs/smarty/Smarty.class.php');
$smarty = new Smarty();
$smarty->template_dir = 'views';
$smarty->compile_dir = 'tmp';
$smarty->cache_dir = 'cache';

require_once('../config/config.php');
include('php/user_cms.class.php');

$module = 'index';
$title = $title_default = 'CMS created by Kamil Wyremski';
	
if($user_cms->logged_in){
	if(isset($_GET['module']) and is_slug($_GET['module'])){
		if(file_exists('modules/'.$_GET['module'].'.php')){
			$module = $_GET['module'];
			$title = lang(ucfirst($module)).' - '.$title_default;
		}else{
			$module = '404';
		}
	}
}
include('modules/'.$module.'.php');

$smarty->assign('title', $title);
$smarty->assign('module',$module);
$smarty->assign('settings',$settings);
$smarty->assign('user_cms', $user_cms);
$smarty->assign('links',$links);

$smarty->display('main.tpl');

