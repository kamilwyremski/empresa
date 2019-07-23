<?php
/************************************************************************
 * The script of company catalogue EMPRESA v 1.2
 * Copyright (c) 2017 - 2019 Kamil Wyremski
 * http://wyremski.pl
 * kamil.wyremski@gmail.com
 * 
 * All right reserved
 * 
*/
 
session_start();

header('Content-Type: text/html; charset=utf-8');

require_once('config/config.php');

require_once('libs/smarty/Smarty.class.php');
$smarty = new Smarty();
$smarty->template_dir = 'views/'.$settings['template'];
$smarty->compile_dir = 'tmp';
$smarty->cache_dir = 'cache';

include('php/user.class.php');
include('php/offer.class.php');
include('php/offers_options.class.php');
include('php/controller.php');

$smarty->assign("settings", $settings);
$smarty->assign('page',$page);
$smarty->assign('links',$links);

$smarty->display('main.tpl');
 
