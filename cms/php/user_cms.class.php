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

class user_cms {

	public $logged_in;
	public $error;
	public $info;
	public $user_data;
	
	public function __construct () {
		global $db;
		$this->logged_in = false;
		$this->error = false;
		$this->info = false;
		
		if(isset($_GET['logOut'])){
			
			$this->logOut();
			header('Location: ../cms');
			die('redirect');
	
		}elseif(isset($_SESSION['user_cms']['id']) and isset($_SESSION['user_cms']['session_code'])){
			
			$sth = $db->prepare('SELECT '._DB_PREFIX_.'cms.id, '._DB_PREFIX_.'cms.username FROM '._DB_PREFIX_.'cms_session, '._DB_PREFIX_.'cms WHERE user_id='._DB_PREFIX_.'cms.id AND '._DB_PREFIX_.'cms.id=:id AND code=:code LIMIT 1');
			$sth->bindValue(':id', $_SESSION['user_cms']['id'], PDO::PARAM_INT);
			$sth->bindValue(':code', $_SESSION['user_cms']['session_code'], PDO::PARAM_STR);
			$sth->execute();
			$user = $sth->fetch(PDO::FETCH_ASSOC);
			if($user){
				$this->user_data = $user;
				$this->logged_in = true;
			}else{
				unset($_SESSION['user_cms']);
			}
		}
	}
	
	public function __get($value){
		return $this->user_data[$value];
	}
	
	public function login($data){
		global $db;
		
		$sth = $db->prepare('SELECT 1 FROM '._DB_PREFIX_.'cms_logs WHERE logged=0 AND date > DATE_ADD(NOW(), INTERVAL -30 MINUTE) AND ip=:ip');
		$sth->bindValue(':ip', get_client_ip(), PDO::PARAM_STR);
		$sth->execute();
		if($sth->rowCount()<5){
			
			$sth = $db->prepare('SELECT '._DB_PREFIX_.'cms.id, '._DB_PREFIX_.'cms.username FROM '._DB_PREFIX_.'cms_session, '._DB_PREFIX_.'cms WHERE username=:username AND password=:password AND code=:code AND ip=:ip LIMIT 1');
			$sth->bindValue(':username', $data['username'], PDO::PARAM_STR);
			$sth->bindValue(':password', $this->createPassword($data['password']), PDO::PARAM_STR);
			$sth->bindValue(':code', $data['session_code'], PDO::PARAM_STR);
			$sth->bindValue(':ip', get_client_ip(), PDO::PARAM_STR);
			$sth->execute();
			$user = $sth->fetch(PDO::FETCH_ASSOC);
			if($user){

				$_SESSION['user_cms']['id'] = $user['id'];
				$_SESSION['user_cms']['session_code'] = $data['session_code'];
				
				$sth = $db->prepare('UPDATE `'._DB_PREFIX_.'cms_session` SET user_id=:id WHERE code=:code');
				$sth->bindValue(':id', $user['id'], PDO::PARAM_STR);
				$sth->bindValue(':code', $data['session_code'], PDO::PARAM_STR);
				$sth->execute();
				$sth->closeCursor();
				
				$this->logged_in = true;
				$this->saveLogs(true,$user['username']);
				
				if(!empty($_GET['module'])){header('Location: '.$_SERVER['REQUEST_URI']);}

			}else{
				$this->error = lang('The entered data is incorrect');
				$this->removeSessionCode($data['session_code']);
				$this->saveLogs(false,$data['username']);
			}
		}else{
			$this->error = lang('Exceeded the limit login attempts');
		}
	}
	
	public function newSessionCode(){
		global $db;
		$this->logOut();
		$session_code = md5(uniqid(rand(), true));		
		$sth = $db->prepare('INSERT INTO `'._DB_PREFIX_.'cms_session`(`code`, `ip`, `date`) VALUES (:code,:ip,NOW())');
		$sth->bindValue(':code', $session_code, PDO::PARAM_STR);
		$sth->bindValue(':ip', get_client_ip(), PDO::PARAM_STR);
		$sth->execute();
		return($session_code);
	}
	
	public function removeSessionCode($session_code){
		global $db;
		$sth = $db->prepare('DELETE FROM `'._DB_PREFIX_.'cms_session` WHERE code=:code');
		$sth->bindValue(':code', $session_code, PDO::PARAM_STR);
		$sth->execute();
	}
	
	public function logOut(){
		$this->logged_in = false;
		unset($_SESSION['user_cms']);
	}
	
	public function createPassword($password){
		return md5($password);
	}
	
	public function saveLogs($logged=false,$username=''){
		global $db;
		$sth = $db->prepare('INSERT INTO `'._DB_PREFIX_.'cms_logs`(`username`, `logged`, `ip`, `date`) VALUES (:username, :logged, :ip, NOW())');
		$sth->bindValue(':username', $username, PDO::PARAM_STR);
		$sth->bindValue(':logged', $logged, PDO::PARAM_INT);
		$sth->bindValue(':ip', get_client_ip(), PDO::PARAM_STR);
		$sth->execute();
	}
	
	public function changeUser($data){
		global $db;
		if($data['new_password']==$data['repeat_new_password']){
			if($data['new_username']!=$this->username){
				$sth = $db->prepare('SELECT 1 FROM '._DB_PREFIX_.'cms WHERE username=:username AND id!=:id LIMIT 1');
				$sth->bindValue(':username', $data['new_username'], PDO::PARAM_STR);
				$sth->bindValue(':id', $this->id, PDO::PARAM_INT);
				$sth->execute();
				if($sth->fetchColumn()){
					$this->error = lang('The selected username is already taken');
					return false;
				}
			}
			
			$sth = $db->prepare('UPDATE '._DB_PREFIX_.'cms SET username=:new_username, password=:password WHERE id=:id LIMIT 1');
			$sth->bindValue(':new_username', $data['new_username'], PDO::PARAM_STR);
			$sth->bindValue(':password', $this->createPassword($data['new_password']), PDO::PARAM_STR);
			$sth->bindValue(':id', $this->id, PDO::PARAM_INT);
			$sth->execute();
			
			$this->username = $data['new_username'];
			$this->info = lang('The data have been updated');
		}else{
			$this->error = lang('Entered passwords are different.');
		}
	}
	
	public function removeLogs(){
		global $db;
		$db->query('TRUNCATE cms_logs');		
		$this->info = lang('Logs logon panel CMS has been successfully removed');
	}
	
	public function getLogs(){
		global $db;
		$limit = 100;
		$cms_logs = array();
		$sth = $db->query('SELECT * FROM '._DB_PREFIX_.'cms_logs ORDER BY '.sort_by().' LIMIT '.page_count('cms_logs',$limit).','.$limit.'');
		while($row = $sth->fetch(PDO::FETCH_ASSOC)) {$cms_logs[] = $row;}
		$sth->closeCursor();
		return $cms_logs;
	}
	
	public function getUsers(){
		global $db;
		$sth = $db->query('SELECT * FROM '._DB_PREFIX_.'cms ORDER BY username');
		while($row = $sth->fetch(PDO::FETCH_ASSOC)) {$cms_users[] = $row;}
		$sth->closeCursor();
		return $cms_users;
	}
	
	public function addUser($data){
		global $db;
		if($data['password']==$data['repeat_password']){
			$sth = $db->prepare('SELECT 1 FROM '._DB_PREFIX_.'cms WHERE username=:username LIMIT 1');
			$sth->bindValue(':username', $data['username'], PDO::PARAM_STR);
			$sth->execute();
			if(!$sth->fetchColumn()){
				$sth = $db->prepare('INSERT INTO '._DB_PREFIX_.'cms (username, password) VALUES(:username, :password)');
				$sth->bindValue(':username', $data['username'], PDO::PARAM_STR);
				$sth->bindValue(':password', $this->createPassword($data['password']), PDO::PARAM_STR);
				$sth->execute();
				$this->info = lang('Added new user');
			}else{
				$this->error = lang('The selected username is already taken');
			}			
		}else{
			$this->error = lang('Entered passwords are different.');
		}
	}
	
	public function removeUser($id){
		global $db;
		if($id!=$this->id){
			$sth = $db->prepare('DELETE FROM '._DB_PREFIX_.'cms WHERE id=:id LIMIT 1');
			$sth->bindValue(':id', $id, PDO::PARAM_INT);
			$sth->execute();
			$this->info = lang('User CMS has been successfully removed');
		}else{
			$this->error = lang('You can not delete a user who is logged');
		}
	}
	
	public function logOutAll(){
		global $db;
		$db->query('TRUNCATE cms_session');
		header('Location: ../cms');
		die('redirect');
	}
}

$user_cms = new user_cms();

?>