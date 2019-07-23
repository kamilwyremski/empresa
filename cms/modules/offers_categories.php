<?php
/************************************************************************
 * The script of company catalogue EMPRESA
 * Copyright (c) 2017 - 2019 Kamil Wyremski
 * http://wyremski.pl
 * kamil.wyremski@gmail.com
 * 
 * All right reserved
 * 
 * *********************************************************************
 * THIS SOFTWARE IS LICENSED - YOU CAN MODIFY THESE FILES
 * BUT YOU CAN NOT REMOVE OF ORIGINAL COMMENTS!
 * ACCORDING TO THE LICENSE YOU CAN USE THE SCRIPT ON ONE DOMAIN. DETECTION
 * COPY SCRIPT WILL RESULT IN A HIGH FINANSIAL PENALTY AND WITHDRAWAL
 * LICENSE THE SCRIPT
 * *********************************************************************/
 
if(!isset($settings['base_url'])){
	die('Access denied!');
}

if($user_cms->logged_in){

	if(!_CMS_TEST_MODE_ and isset($_POST['action'])){
		if($_POST['action']=='add_category' and isset($_POST['name']) and $_POST['name']!=''){
			$sth = $db->prepare('INSERT INTO `'._DB_PREFIX_.'offers_categories`(`slug`, `name`) VALUES (:slug,:name)');
			$sth->bindValue(':slug', slug($_POST['name']), PDO::PARAM_STR);
			$sth->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
			$sth->execute();
		}elseif($_POST['action']=='edit_category' and isset($_POST['id']) and $_POST['id']>0 and isset($_POST['name']) and $_POST['name']!=''){
			$sth = $db->prepare('UPDATE `'._DB_PREFIX_.'offers_categories` SET  slug=:slug, name=:name WHERE id=:id limit 1');
			$sth->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
			$sth->bindValue(':slug', slug($_POST['name']), PDO::PARAM_STR);
			$sth->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
			$sth->execute();
		}elseif($_POST['action']=='remove_category' and isset($_POST['id']) and $_POST['id']>0){
			$sth = $db->prepare('DELETE FROM `'._DB_PREFIX_.'offers_categories` WHERE id=:id limit 1');
			$sth->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
			$sth->execute();
		}
	}

	get_offers_categories();
	
	$title = lang('Categories').' - '.$title_default;
}
