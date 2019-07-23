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

if($settings['enable_articles']){
	$limit = 10;
	$sth = $db->prepare('SELECT * FROM '._DB_PREFIX_.'articles ORDER BY date desc LIMIT :limit_from, :limit_to');
	$sth->bindValue(':limit_from', page_count('articles', $limit), PDO::PARAM_INT);
	$sth->bindValue(':limit_to', $limit, PDO::PARAM_INT);
	$sth->execute();
	while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
		$articles[] = $row;
	}
	$sth->closeCursor();
	if(isset($articles )){$smarty->assign("articles", $articles);}
	$settings['seo_title'] = lang('Articles').' - '.$settings['title'];
	$settings['seo_description'] = lang('Articles').' - '.$settings['description'];
}else{
	include('model/404.php');
}
?>