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

	$limit = 100;

  $sth = $db->prepare('SELECT * FROM '._DB_PREFIX_.'payments_dotpay ORDER BY '.sort_by().' LIMIT :limit_from, :limit_to');
	$sth->bindValue(':limit_from', page_count('payments_dotpay', $limit), PDO::PARAM_INT);
	$sth->bindValue(':limit_to', $limit, PDO::PARAM_INT);
	$sth->execute();
	while ($row = $sth->fetch(PDO::FETCH_ASSOC)){
		$sth2 = $db->prepare('SELECT id, slug, name FROM '._DB_PREFIX_.'offers where id=:offer_id');
		$sth2->bindValue(':offer_id', $row['offer_id'], PDO::PARAM_INT);
		$sth2->execute();
		$row['offer'] = $sth2->fetch(PDO::FETCH_ASSOC);
		$sth2->closeCursor();
		$payments_dotpay[] = $row;
	}
	$sth->closeCursor();
	if(isset($payments_dotpay)){$smarty->assign("payments_dotpay", $payments_dotpay);}

}
