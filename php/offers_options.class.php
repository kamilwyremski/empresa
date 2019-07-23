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

class offers_options {
	
	public function __construct () {
		$this->kinds = array('text'=>lang('Text field'),'number'=>lang('Numeric field'),'select'=>lang('Select field'));
	}
	
	public function getKinds(){
		global $smarty;
		if(isset($smarty)){$smarty->assign("offers_options_kinds", $this->kinds);}
		return $this->kinds;
	}
	
	public function getOptions(){
		global $smarty, $db;
		$sth = $db->query('SELECT * FROM '._DB_PREFIX_.'offers_options ORDER BY position');
		foreach($sth as $row){
			$row['kindName'] = $this->getKindName($row['kind']);
			if($row['kind']=='select'){
				$row['choices'] = $this->getSelectChoices($row['select_choices']);
			}
			$offers_options[$row['id']] = $row;
		}
		$sth->closeCursor();
		if(isset($smarty) and isset($offers_options)){$smarty->assign("offers_options", $offers_options);}
	}
	
	public function getOption($id){
		global $smarty, $db;
		$sth = $db->prepare('SELECT * FROM '._DB_PREFIX_.'offers_options WHERE id=:id LIMIT 1');
		$sth->bindValue(':id', $id, PDO::PARAM_INT);
		$sth->execute();
		$offers_option = $sth->fetch(PDO::FETCH_ASSOC);
		if($offers_option){
			$smarty -> assign('offers_option',$offers_option);
		}
	}
	
	public function getSelectChoices($choices){
		return array_filter(array_map('trim', explode(',',$choices)));
	}
	
	public function getKindName($name){
		if(isset($this->kinds[$name])){
			return $this->kinds[$name];
		}
		return '';
	}
	
	public function add($data){
		global $db;
		$sth = $db->prepare('INSERT INTO `'._DB_PREFIX_.'offers_options`(`position`) VALUES (:position)');
		$sth->bindValue(':position', getPosition('offers_options'), PDO::PARAM_INT);		
		$sth->execute();
		$this->edit($db->lastInsertId(),$data);
	}
	
	public function edit($id,$data){
		global $db;
		if($id>0 and $this->checkKind($data['kind'])){
			if(!empty($data['select_choices'])){$select_choices = $data['select_choices'];}else{$select_choices = '';}
			$sth = $db->prepare('UPDATE `'._DB_PREFIX_.'offers_options` SET name=:name, slug=:slug, kind=:kind, required=:required, select_choices=:select_choices WHERE id=:id LIMIT 1');
			$sth->bindValue(':name', $data['name'], PDO::PARAM_STR);
			$sth->bindValue(':slug', slug(strip_tags($data['name'])), PDO::PARAM_STR);
			$sth->bindValue(':kind', $data['kind'], PDO::PARAM_STR);
			$sth->bindValue(':required', isset($data['required']), PDO::PARAM_INT);
			$sth->bindValue(':select_choices', $select_choices, PDO::PARAM_STR);
			$sth->bindValue(':id', $id, PDO::PARAM_INT);				
			$sth->execute();
		}
	}
	
	public function checkKind($name){
		if(isset($this->kinds[$name])){
			return true;
		}
		return false;
	}

	public function remove($id){
		global $db;
		$sth = $db->prepare('DELETE FROM `'._DB_PREFIX_.'offers_options` WHERE id=:id limit 1');
		$sth->bindValue(':id', $id, PDO::PARAM_INT);
		$sth->execute();
		$sth = $db->prepare('DELETE FROM `'._DB_PREFIX_.'offers_options_values` WHERE option_id=:option_id');
		$sth->bindValue(':option_id', $id, PDO::PARAM_INT);
		$sth->execute();
	}
}

?>