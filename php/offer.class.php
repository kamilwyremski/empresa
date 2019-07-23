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

class offer {
	
	public function __get($value){
		return $this->offer_data[$value];
	}
	
	public function loadOffers($limit=10,$type='all'){
		global $db, $smarty, $settings, $user;
		$limit = (int)$limit;
		$where_statement = ' true ';
		$select = '';
		if(isset($_GET['search'])){
			if(isset($_GET['id']) and $_GET['id']>0){
				$where_statement .= ' AND id = "'.filter($_GET['id']).'" ';
			}
			if(!empty($_GET['username'])){
				$where_statement .= ' and user_id = (SELECT id FROM '._DB_PREFIX_.'users WHERE username="'.filter($_GET['username']).'" LIMIT 1) ';
			}
			if(isset($_GET['name']) and $_GET['name']!=''){
				$names = explode(' ', $_GET['name']);
				$where_statement .= ' and ( ';
				for($i=0; $i < count($names); $i++){
					$where_statement .= ' slug like "%'.filter(slug($names[$i])).'%"  ';
					if($i!=(count($names)-1)){$where_statement .= ' or ';}
				}
				$where_statement .= ' ) ';
			}
			if(!empty($_GET['keywords'])){
				$keywords = explode(' ', $_GET['keywords']);
				$where_statement .= ' AND ( ';
				for($i=0; $i < count($keywords); $i++){
					$where_statement .= ' (slug LIKE "%'.filter(slug($keywords[$i])).'%" OR description LIKE "%'.filter($keywords[$i]).'%") ';
					if($i!=(count($keywords)-1)){$where_statement .= ' or ';}
				}
				$where_statement .= ' ) ';
			}
			if(isset($_GET['category']) and is_array($_GET['category'])){
				$where_statement .= ' and (';
				$last = count($_GET['category']);
				foreach($_GET['category'] as $key => $value){
					$where_statement .= ' category = (select id from '._DB_PREFIX_.'offers_categories where slug="'.filter($value).'" limit 1) ';
					if(($last-1)!=$key){$where_statement .= ' or ';}
				}
				$where_statement .= ') ';
			}
			if(isset($_GET['state']) and is_array($_GET['state'])){
				$where_statement .= ' and (';
				$last = count($_GET['state']);
				foreach($_GET['state'] as $key => $value){
					$where_statement .= ' state = (SELECT id FROM '._DB_PREFIX_.'offers_state WHERE slug="'.filter($value).'" LIMIT 1) ';
					if(($last-1)!=$key){$where_statement .= ' or ';}
				}
				$where_statement .= ') ';
			}
			if(isset($_GET['user_id']) and $_GET['user_id']>0){
				$where_statement .= ' and user_id="'.filter($_GET['user_id']).'" ';
			}
			if(isset($_GET['active'])){
				if($_GET['active']=='yes'){
					$where_statement .= ' and active="1" ';
				}elseif($_GET['active']=='no'){
					$where_statement .= ' and active="0" ';
				}
			}
			if(isset($_GET['promoted'])){
				if($_GET['promoted']=='yes'){
					$where_statement .= ' and promoted="1" ';
				}elseif($_GET['promoted']=='no'){
					$where_statement .= ' and (promoted="0" OR promoted is null) ';
				}
			}
			if(isset($_GET['distance']) and $_GET['distance']>0){
				$address = '';
				if(isset($_GET['address']) and $_GET['address']!=''){
					$address .= ' '.filter($_GET['address']);
				}
				if($address){
					$coordinates = get_coordinates($address);
					$select = ' , (6371 * acos( cos( radians('.$coordinates['lat'].')) * cos( radians(address_lat) ) * cos( radians(address_long) - radians('.$coordinates['long'].')) + sin(radians('.$coordinates['lat'].')) * sin(radians(address_lat)))) AS distance '; 
					$where_statement .= ' and address_lat!=0 and address_long!=0 HAVING distance < '.intval($_GET['distance']).' ';
				}
			}else{
				if(isset($_GET['address']) and $_GET['address']!=''){
					$where_statement .= ' and address like "%'.filter($_GET['address']).'%"  ';
				}
			}
			if(isset($_GET['options']) and is_array($_GET['options'])){
				$where_statement .= ' and (';
				$last = count($_GET['options']);
				$i = 0;
				foreach($_GET['options'] as $key => $value){
					if(is_array($value)){
						$where_statement .= ' ( ';
						if(isset($value['from']) || isset($value['to'])){
							if(isset($value['from']) and $value['from']>=0){
								$where_statement .= ' (SELECT count(1) FROM '._DB_PREFIX_.'offers_options_values, '._DB_PREFIX_.'offers_options WHERE '._DB_PREFIX_.'offers_options.id=offers_options_values.option_id AND slug="'.filter($key).'" AND offer_id='._DB_PREFIX_.'offers.id AND CAST(value AS UNSIGNED) >='.intval($value['from']).' LIMIT 1) > 0 ';
								
							}
							if(isset($value['from']) and $value['from']>=0 and isset($value['to']) and $value['to']>=0){$where_statement .= ' AND ';}
							if(isset($value['to']) and $value['to']>=0){
								$where_statement .= ' (SELECT count(1) FROM '._DB_PREFIX_.'offers_options_values, '._DB_PREFIX_.'offers_options WHERE '._DB_PREFIX_.'offers_options.id=offers_options_values.option_id AND slug="'.filter($key).'" AND offer_id='._DB_PREFIX_.'offers.id AND CAST(value AS UNSIGNED) <='.intval($value['to']).' LIMIT 1) > 0 ';
							}
							
						}else{
							$last2 = count($value);
							$j = 0;
							foreach($value as $key2 => $value2){
								$where_statement .= ' (SELECT count(1) FROM '._DB_PREFIX_.'offers_options_values, '._DB_PREFIX_.'offers_options WHERE '._DB_PREFIX_.'offers_options.id=offers_options_values.option_id AND slug="'.filter($key).'" AND offer_id='._DB_PREFIX_.'offers.id AND value ="'.filter($value2).'" LIMIT 1) > 0 ';
								if($j!=$last2-1){$where_statement .= ' OR ';}
								$j++;
							}
						}
						$where_statement .= ' ) ';
					}else{
						$where_statement .= ' (SELECT count(1) FROM '._DB_PREFIX_.'offers_options_values, '._DB_PREFIX_.'offers_options WHERE '._DB_PREFIX_.'offers_options.id=offers_options_values.option_id AND slug="'.filter($key).'" AND offer_id='._DB_PREFIX_.'offers.id AND value LIKE "%'.filter($value).'%" LIMIT 1) > 0 ';
					}
					if($i!=$last-1){$where_statement .= ' AND ';}
					$i++;
				}
				$where_statement .= ') ';
			}
		}
		$sort = ' rand() ';
		if(isset($_GET['sort'])){
			if($_GET['sort']=='random'){
				$sort = ' rand() ';
			}elseif($_GET['sort']=='newest'){
				$sort = ' id desc ';
			}elseif($_GET['sort']=='oldest'){
				$sort = ' id ';
			}elseif($_GET['sort']=='a-z'){
				$sort = ' name, id DESC ';
			}elseif($_GET['sort']=='z-a'){
				$sort = ' name DESC, id DESC ';
			}elseif($_GET['sort']=='nearest'){
				if($select){
					$sort = ' distance, id DESC ';
				}
			}elseif($_GET['sort']=='farthest'){
				if($select){
					$sort = ' distance DESC, id DESC ';
				}
			}else{
				$sort = sort_by();
			}
		}
		if($type=='my_offers'){
			$where_statement .= ' and user_id='.$user->id.' ';
		}elseif($type=='all'){
			$where_statement .= ' and active=1 ';
		}elseif($type=='rss'){
			$where_statement .= ' and active=1 ';
			$sort = ' id DESC ';
		}
		if($type!='all_cms'){
			$sort = ' ifnull(promoted,0) DESC, '.$sort;
		}
		
		$sth = $db->prepare('SELECT * '.$select.', 
			(SELECT thumb FROM '._DB_PREFIX_.'photos WHERE offer_id='._DB_PREFIX_.'offers.id LIMIT 1) AS thumb 
			FROM '._DB_PREFIX_.'offers WHERE '.$where_statement.' ORDER BY '.$sort.' LIMIT :limit_from, :limit_to');
	
		$sth->bindValue(':limit_from', page_count('offers', $limit, $where_statement, ', active '.$select), PDO::PARAM_INT);
		$sth->bindValue(':limit_to', $limit, PDO::PARAM_INT);
		$sth->execute();
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)){
			$row['category'] = $this->getCategory($row['category']);
			$row['state'] = $this->getState($row['state']);
			if(isset($smarty) and ($row['address_lat']!=0 or $row['address_long']!=0)){$smarty->assign("offers_show_map", true);}
			if($type=='all_cms'){
				$sth2 = $db->prepare('SELECT username, email FROM '._DB_PREFIX_.'users WHERE id=:id LIMIT 1');
				$sth2->bindValue(':id', $row['user_id'], PDO::PARAM_INT);
				$sth2->execute();
				$row['user'] = $sth2->fetch(PDO::FETCH_ASSOC);
				$sth2->closeCursor();
				$row['view'] = $this->getViews($row['id']);
				
			}
			$offers[] = $row;
		}
		$sth->closeCursor();
		if(isset($offers)){
			$this->offer_data = $offers;
			if(isset($smarty)){$smarty->assign("offers", $offers);}
		}
	}
	
	public function addOffer($data){
		global $db, $user, $settings, $links;
		$code = md5(uniqid(rand(), true));
		
		$sth = $db->prepare('INSERT INTO `'._DB_PREFIX_.'offers`(`user_id`, `name`, `slug`, `active`, `code`, `date`) VALUES (:user_id,:name,:slug,:active,:code,NOW())');
		$sth->bindValue(':user_id', $user->getId(), PDO::PARAM_INT);
		$sth->bindValue(':name', $data['name'], PDO::PARAM_STR);
		$sth->bindValue(':slug', slug($data['name']), PDO::PARAM_STR);
		$sth->bindValue(':active', $settings['automatically_activate_offers'], PDO::PARAM_INT);
		$sth->bindValue(':code', $code, PDO::PARAM_STR);
		$sth->execute();
		$id = $db->lastInsertId();
		$this->editOffer($id,$data);
		
		$offer_edit_link = $links['edit'].'/'.$id.','.slug($data['name']).'?code='.$code;
		
		send_mail('offer_start',$data['email'],array('offer_edit_link'=>$offer_edit_link, 'offer_name'=>$data['name'], 'offer_url'=>$id.','.slug($data['name'])));
		
		header("Location: ".$settings['base_url']."/".$id.",".slug($data['name']));
		die('redirect');
	}
	
	public function editOffer($id,$data){
		global $db, $settings, $user;
		
		$slug = slug(strip_tags($data['name']));
		if(!empty($data['address'])){$data['address'] = trim(strip_tags($data['address']));}else{$data['address'] = null;}
		if(empty($data['category'])){$data['category'] = 0;}
		if(empty($data['state'])){$data['state'] = 0;}
		if(!empty($data['address_lat'])){$data['address_lat'] = strval($data['address_lat']);}else{$data['address_lat'] = 0;}
		if(!empty($data['address_long'])){$data['address_long'] = strval($data['address_long']);}else{$data['address_long'] = 0;}

		$sth = $db->prepare('UPDATE '._DB_PREFIX_.'offers SET name=:name, slug=:slug, address=:address, url=:url, phone=:phone, phone_mobile=:phone_mobile, email=:email, category=:category, state=:state, description=:description, address_lat=:address_lat, address_long=:address_long WHERE id=:id LIMIT 1');
		$sth->bindValue(':id', $id, PDO::PARAM_INT);
		$sth->bindValue(':name', trim(strip_tags($data['name'])), PDO::PARAM_STR);
		$sth->bindValue(':slug', $slug, PDO::PARAM_STR);
		$sth->bindValue(':address', trim($data['address']), PDO::PARAM_STR);
		$sth->bindValue(':url', web_address(trim(strip_tags($data['url']))), PDO::PARAM_STR);
		$sth->bindValue(':phone', trim(strip_tags($data['phone'])), PDO::PARAM_STR);
		$sth->bindValue(':phone_mobile', trim(strip_tags($data['phone_mobile'])), PDO::PARAM_STR);
		$sth->bindValue(':email', trim(strip_tags($data['email'])), PDO::PARAM_STR);
		$sth->bindValue(':category', strip_tags($data['category']), PDO::PARAM_STR);
		$sth->bindValue(':state', strip_tags($data['state']), PDO::PARAM_STR);
		$sth->bindValue(':description', nofollow(purify(trim($data['description']))), PDO::PARAM_STR);
		$sth->bindValue(':address_lat', strip_tags($data['address_lat']), PDO::PARAM_STR);
		$sth->bindValue(':address_long', strip_tags($data['address_long']), PDO::PARAM_STR);
		$sth->execute();
		$sth->closeCursor();
		
		if($settings['photo_add'] and isset($data['photos']) and $data['photos']!=''){
			$where_statement = filter(' id!='.implode($data['photos'],' and id!= '));
		}else{
			$where_statement = ' true ';
		}
		$sth = $db->prepare('SELECT * from '._DB_PREFIX_.'photos WHERE offer_id=:offer_id and ('.$where_statement.')');
		$sth->bindValue(':offer_id', $id, PDO::PARAM_INT);
		$sth->execute();
		foreach($sth as $row){;
			unlink(realpath(dirname(__FILE__)).'/../upload/photos/'.$row['thumb']);
			unlink(realpath(dirname(__FILE__)).'/../upload/photos/'.$row['url']);
		}
		$sth->closeCursor();
		$sth = $db->prepare('DELETE from '._DB_PREFIX_.'photos WHERE offer_id=:offer_id and ('.$where_statement.')');
		$sth->bindValue(':offer_id', $id, PDO::PARAM_INT);
		$sth->execute();
		$sth->closeCursor();

		if($settings['photo_add'] and isset($data['photos']) and $data['photos']!=''){
			
			$sth = $db->prepare('SELECT * from '._DB_PREFIX_.'photos WHERE id=:id and user_id=:user_id LIMIT 1');
			foreach($data['photos'] as $key => $value){
				$sth->bindValue(':id', $value, PDO::PARAM_INT);
				$sth->bindValue(':user_id', $user->getId(), PDO::PARAM_INT);
				$sth->execute();
				$photo = $sth->fetch(PDO::FETCH_ASSOC);
				if($photo!=''){
					$sth2 = $db->prepare('UPDATE `'._DB_PREFIX_.'photos` SET offer_id=:offer_id WHERE id=:id');
					$sth2->bindValue(':offer_id', $id, PDO::PARAM_INT);
					$sth2->bindValue(':id', $photo['id'], PDO::PARAM_INT);
					$sth2->execute();
					$sth2->closeCursor();
				}
			}
			$sth->closeCursor();
		}
		
		$sth = $db->prepare('DELETE from '._DB_PREFIX_.'offers_options_values WHERE offer_id=:offer_id');
		$sth->bindValue(':offer_id', $id, PDO::PARAM_INT);
		$sth->execute();
		$sth->closeCursor();
		if(isset($data['options']) and is_array($data['options'])){
			$sth = $db->prepare('INSERT INTO `'._DB_PREFIX_.'offers_options_values`(`offer_id`, `option_id`, `value`) VALUES (:offer_id, :option_id, :value)');
			$sth->bindValue(':offer_id', $id, PDO::PARAM_INT);
			foreach($data['options'] as $key=>$value){
				if($value){
					$sth->bindValue(':option_id', $key, PDO::PARAM_INT);
					$sth->bindValue(':value', strip_tags($value), PDO::PARAM_STR);
					$sth->execute();
				}
			}
			$sth->closeCursor();
		}
	}
	
	public function loadOffer($id,$all_data=false){
		global $db, $smarty, $user, $settings;
		$sth = $db->prepare('SELECT * FROM '._DB_PREFIX_.'offers WHERE id=:id LIMIT 1');
		$sth->bindValue(':id', $id, PDO::PARAM_INT);
		$sth->execute();
		$offer = $sth->fetch(PDO::FETCH_ASSOC);
		if($offer!=''){
			$sth->closeCursor();
			$sth = $db->prepare('SELECT * FROM '._DB_PREFIX_.'photos WHERE offer_id=:offer_id');
			$sth->bindValue(':offer_id', $id, PDO::PARAM_INT);
			$sth->execute();
			while ($row = $sth->fetch(PDO::FETCH_ASSOC)){
				$offer['photos'][] = $row;
			}
			$sth->closeCursor();
			
			if(isset($offer['photos'])){$settings['logo_facebook'] = $settings['base_url'].'/upload/'.$offer['photos'][0]['thumb'];}
			
			$sth = $db->prepare('SELECT name, id, value FROM '._DB_PREFIX_.'offers_options_values, '._DB_PREFIX_.'offers_options WHERE '._DB_PREFIX_.'offers_options_values.option_id = '._DB_PREFIX_.'offers_options.id and '._DB_PREFIX_.'offers_options_values.offer_id=:offer_id');
			$sth->bindValue(':offer_id', $id, PDO::PARAM_INT);
			$sth->execute();
			while ($row = $sth->fetch(PDO::FETCH_ASSOC)){
				$offer['options'][$row['id']] = $row;
			}
			$sth->closeCursor();
			
			if($all_data){
				$offer['category'] = $this->getCategory($offer['category']);
				$offer['state'] = $this->getState($offer['state']);
				$offer['user'] = $this->getUser($offer['user_id']);
				
				$sth = $db->prepare('INSERT INTO `'._DB_PREFIX_.'logs_offers`(`offer_id`, `user_id`, `ip`, `date`) VALUES (:offer_id,:user_id,:ip,NOW())');
				$sth->bindValue(':offer_id', $id, PDO::PARAM_INT);
				$sth->bindValue(':user_id', $user->getId(), PDO::PARAM_INT);
				$sth->bindValue(':ip', get_client_ip(), PDO::PARAM_STR);
				$sth->execute();
				$sth->closeCursor();
				
				$offer['view'] = $this->getViews($id);
				
			}
			$this->offer_data = $offer;
			if(isset($smarty)){$smarty->assign("offer", $offer);}
			return $offer;
		}
	}
	
	public function checkActiveOffer($id){
		global $db, $user;
		$sth = $db->prepare('SELECT 1 from '._DB_PREFIX_.'offers WHERE (active=1 or user_id=:user_id) and id=:id LIMIT 1');
		$sth->bindValue(':id', $id, PDO::PARAM_INT);
		$sth->bindValue(':user_id', $user->id, PDO::PARAM_INT);
		$sth->execute();
		if($sth->fetchColumn()){
			return true;
		}
		return false;
	}
	
	public function checkPermissions($id,$code=''){
		global $user, $db;
		if($user->logged_in){
			if($user->moderator){return true;}
			$user_id = $user->id;
			$sth = $db->prepare('SELECT 1 FROM '._DB_PREFIX_.'offers WHERE id=:id AND user_id=:user_id LIMIT 1');
			$sth->bindValue(':user_id', $user_id, PDO::PARAM_INT);
		}else{
			if(empty($code)){
				return false;
			}else{
				$sth = $db->prepare('SELECT 1 FROM '._DB_PREFIX_.'offers WHERE id=:id AND code=:code LIMIT 1');
				$sth->bindValue(':code', $code, PDO::PARAM_STR);
			}
		}
		$sth->bindValue(':id', $id, PDO::PARAM_INT);
		$sth->execute();
		if($sth->fetchColumn()){return true;}
		return false;
	}
	
	public function newSessionCode(){
		global $db, $smarty, $user;
		$session_code = md5(uniqid(rand(), true));		
		$sth = $db->prepare('INSERT INTO `'._DB_PREFIX_.'session_offer`(`user_id`, `code`, `ip`, `date`) VALUES (:user_id,:code,:ip,NOW())');
		$sth->bindValue(':user_id', $user->getId(), PDO::PARAM_INT);
		$sth->bindValue(':code', $session_code, PDO::PARAM_STR);
		$sth->bindValue(':ip', get_client_ip(), PDO::PARAM_STR);
		$sth->execute();
		if(isset($smarty)){$smarty->assign("session_code", $session_code);}
	}
	
	public function checkSessionCode($session_code){
		global $db, $settings;
		if($settings['check_ip_user']){
			$sth = $db->prepare('SELECT 1 from '._DB_PREFIX_.'session_offer WHERE code=:code AND ip=:ip LIMIT 1');
			$sth->bindValue(':ip', get_client_ip(), PDO::PARAM_STR);
		}else{
			$sth = $db->prepare('SELECT 1 from '._DB_PREFIX_.'session_offer WHERE code=:code LIMIT 1');
		}
		$sth->bindValue(':code', $session_code, PDO::PARAM_STR);
		$sth->execute();
		if($sth->fetchColumn()){
			$this->removeSessionCode($session_code);
			return true;
		}
		return false;
	}
	
	public function removeSessionCode($session_code){
		global $db;
		$sth = $db->prepare('DELETE FROM `'._DB_PREFIX_.'session_offer` WHERE code=:code');
		$sth->bindValue(':code', $session_code, PDO::PARAM_STR);
		$sth->execute();
	}
	
	public function getCategory($id){
		global $db;
		$category = array('name'=>'','slug'=>'');
		$sth = $db->prepare('SELECT * from '._DB_PREFIX_.'offers_categories WHERE id=:id LIMIT 1');
		$sth->bindValue(':id', $id, PDO::PARAM_INT);
		$sth->execute();
		$category = $sth->fetch(PDO::FETCH_ASSOC);
		return $category;
	}
	
	public function getState($id){
		global $db;
		$state = array('name'=>'','slug'=>'');
		$sth = $db->prepare('SELECT * from '._DB_PREFIX_.'offers_state WHERE id=:id LIMIT 1');
		$sth->bindValue(':id', $id, PDO::PARAM_INT);
		$sth->execute();
		$state = $sth->fetch(PDO::FETCH_ASSOC);
		return $state;
	}
	
	public function getUser($id){
		global $db;
		$sth = $db->prepare('SELECT id, username from '._DB_PREFIX_.'users WHERE id=:id LIMIT 1');
		$sth->bindValue(':id', $id, PDO::PARAM_INT);
		$sth->execute();
		$user = $sth->fetch(PDO::FETCH_ASSOC);
		return $user;
	}
	
	public function getViews($id){
		global $db;
		$sth = $db->prepare('SELECT 1 FROM '._DB_PREFIX_.'logs_offers WHERE offer_id=:offer_id');
		$sth->bindValue(':offer_id', $id, PDO::PARAM_INT);
		$sth->execute();
		$rows = $sth->fetchAll();
		$all = count($rows);
		
		$sth = $db->prepare('SELECT 1 FROM '._DB_PREFIX_.'logs_offers WHERE offer_id=:offer_id GROUP BY ip');
		$sth->bindValue(':offer_id', $id, PDO::PARAM_INT);
		$sth->execute();
		$rows = $sth->fetchAll();
		$unique = count($rows);
		
		return array('all'=>$all, 'unique'=>$unique);
	}
	
	public function deactivate($id){
		global $db;
		$sth = $db->prepare('UPDATE `'._DB_PREFIX_.'offers` SET active=0 WHERE id=:id limit 1');
		$sth->bindValue(':id', $id, PDO::PARAM_INT);
		$sth->execute();
	}
	
	public function activate($id){
		global $db;
		$sth = $db->prepare('UPDATE `'._DB_PREFIX_.'offers` SET active=1 WHERE id=:id limit 1');
		$sth->bindValue(':id', $id, PDO::PARAM_INT);
		$sth->execute();
	}
	
	public function disablePromote($id){
		global $db;
		$sth = $db->prepare('UPDATE `'._DB_PREFIX_.'offers` SET promoted=0 WHERE id=:id limit 1');
		$sth->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
		$sth->execute();
	}
	
	public function enablePromote($id,$date=false){
		global $db, $settings;
		$offer = $this->loadOffer($id);	
		if($date){
			$promoted_date_end = $date;
		}elseif($offer['promoted'] and $offer['promoted_date_end'] > date("Y-m-d")){
			$promoted_date_end = date('Y-m-d', strtotime($offer['promoted_date_end']. ' + '.$settings['promote_days'].' days'));
		}else{
			$promoted_date_end = date('Y-m-d', strtotime(date("Y-m-d"). ' + '.$settings['promote_days'].' days'));
		}
		$sth = $db->prepare('UPDATE '._DB_PREFIX_.'offers SET promoted=1, promoted_date_end=:promoted_date_end WHERE id=:id LIMIT 1');
		$sth->bindValue(':promoted_date_end', $promoted_date_end, PDO::PARAM_STR);
		$sth->bindValue(':id', $id, PDO::PARAM_INT);
		$sth->execute();
	}
	
	public function remove($id){
		global $db;
		if($id){
			$sth = $db->prepare('DELETE FROM '._DB_PREFIX_.'logs_offers WHERE offer_id=:offer_id');
			$sth->bindValue(':offer_id', $id, PDO::PARAM_INT);
			$sth->execute();
			$sth->closeCursor();
			$sth = $db->prepare('SELECT * from '._DB_PREFIX_.'photos WHERE offer_id=:offer_id');
			$sth->bindValue(':offer_id', $id, PDO::PARAM_INT);
			$sth->execute();
			foreach($sth as $row){;
				unlink(realpath(dirname(__FILE__)).'/../upload/photos/'.$row['thumb']);
				unlink(realpath(dirname(__FILE__)).'/../upload/photos/'.$row['url']);
			}
			$sth->closeCursor();
			$sth = $db->prepare('DELETE from '._DB_PREFIX_.'photos WHERE offer_id=:offer_id');
			$sth->bindValue(':offer_id', $id, PDO::PARAM_INT);
			$sth->execute();
			$sth->closeCursor();
			$sth = $db->prepare('DELETE FROM `'._DB_PREFIX_.'offers_options_values` WHERE offer_id=:offer_id');
			$sth->bindValue(':offer_id', $id, PDO::PARAM_INT);
			$sth->execute();
			$sth->closeCursor();
			$sth = $db->prepare('DELETE FROM '._DB_PREFIX_.'offers WHERE id=:id LIMIT 1');
			$sth->bindValue(':id', $id, PDO::PARAM_INT);
			$sth->execute();
			$sth->closeCursor();
		}
	}
}

?>