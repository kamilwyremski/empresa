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

header('Content-Type: text/html; charset=utf-8');

error_reporting(E_ALL);
error_reporting(0);

ob_start();

$install = true;
include('../config/db.php');

if(isset($mysql_server)){
	header_remove();
	header('location: /cms');
	die('redirect...');
}

$settings['base_url'] = true;
include('../php/global.php');

if(isset($_GET['lang']) and $_GET['lang']!=''){
	$settings['lang'] = load_lang($_GET['lang']);
}else{
	$settings['lang'] = load_lang();
}
$list_of_lang = list_of_lang();

if(isset($_POST['base_url']) and $_POST['base_url']!='' and isset($_POST['serwer']) and $_POST['serwer']!='' and isset($_POST['user']) and $_POST['user']!='' and isset($_POST['name']) and $_POST['name']!='' and isset($_POST['user_cms']) and $_POST['user_cms']!='' and isset($_POST['password_cms']) and $_POST['password_cms']!='' and isset($_POST['password_cms_repeat']) and $_POST['password_cms_repeat']!='' and isset($_POST['email']) and $_POST['email']!='' and isset($_POST['db_prefix']) and isset($_POST['pass_hash'])){

	if($_POST['password_cms']!=$_POST['password_cms_repeat']){
		$error = lang('Error! Entered the password to CMS are different!');
	}else{
		
		define("_DB_PREFIX_", $_POST['db_prefix']);
		
		try{
			$db = new PDO('mysql:host='.$_POST['serwer'].';dbname='.$_POST['name'], $_POST['user'], $_POST['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		}catch (PDOException $e){
			$error = true;
		}

		if (isset($error)) {
			$error = lang('Error! Unable to connect to the server.');
		}else{
		
			$dir = '../config/db.php';
			if (!file_exists($dir) ) {
				fwrite($dir,'');
			}else{
				chmod($dir, 0777);
			}
	 
			file_put_contents('../config/db.php', '<?php
$mysql_server = "'.$_POST['serwer'].'";
$mysql_user = "'.$_POST['user'].'";  
$mysql_pass = "'.$_POST['password'].'"; 
$mysql_db = "'.$_POST['name'].'";

define("_DB_PREFIX_", "'._DB_PREFIX_.'");
define("_PASS_HASH_", "'.$_POST['pass_hash'].'");

');	

			$sql = file_get_contents('empresa.sql');
			
			$sql = str_replace("CREATE TABLE IF NOT EXISTS `","CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_,$sql);
			$sql = str_replace("CREATE TABLE `","CREATE TABLE `"._DB_PREFIX_,$sql);
			$sql = str_replace("INSERT INTO `","INSERT INTO `"._DB_PREFIX_,$sql);
			$sql = str_replace("ALTER TABLE `","ALTER TABLE `"._DB_PREFIX_,$sql);

			$db->exec($sql);
			
			include('../cms/php/user_cms.class.php');
			$password_cms = $user_cms->createPassword($_POST['password_cms']);

			$sth = $db->prepare('SELECT 1 FROM '._DB_PREFIX_.'cms WHERE username=:username LIMIT 1');
			$sth->bindValue(':username', $_POST['user_cms'], PDO::PARAM_STR);
			$sth->execute();
			if($sth->fetchColumn()){
				$sth = $db->prepare('UPDATE '._DB_PREFIX_.'cms SET password=:password WHERE username=:username LIMIT 1');
				$sth->bindValue(':password', $password_cms, PDO::PARAM_STR);
				$sth->bindValue(':username', $_POST['user_cms'], PDO::PARAM_STR);
				$sth->execute();
			}else{
				$sth = $db->prepare('INSERT INTO '._DB_PREFIX_.'cms (`username`, `password`) VALUES (:username, :password)');
				$sth->bindValue(':username', $_POST['user_cms'], PDO::PARAM_STR);
				$sth->bindValue(':password', $password_cms, PDO::PARAM_STR);
				$sth->execute();
			}
		
			$sth = $db->prepare('UPDATE '._DB_PREFIX_.'settings SET value=:base_url WHERE name="base_url" LIMIT 1');
			$sth->bindValue(':base_url', web_address($_POST['base_url']), PDO::PARAM_STR);
			$sth->execute();
			
			$template = 'default';
			if (!file_exists('../views/'.$template) ) {
				$dirs = array_filter(glob('../views/*'), 'is_dir');
				$template = substr($dirs[0],9);
			}
			
			$sth = $db->prepare('UPDATE '._DB_PREFIX_.'settings SET value=:template WHERE name="template" LIMIT 1');
			$sth->bindValue(':template', $template, PDO::PARAM_STR);
			$sth->execute();
			
			$sth = $db->prepare('UPDATE '._DB_PREFIX_.'settings SET value=:email WHERE name="email" LIMIT 1');
			$sth->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
			$sth->execute();
			
			$sth = $db->prepare('UPDATE '._DB_PREFIX_.'settings SET value=:lang WHERE name="lang" LIMIT 1');
			$sth->bindValue(':lang', $settings['lang'], PDO::PARAM_STR);
			$sth->execute();
			
			chmod("../cache", 0777);
			chmod("../cms/cache", 0777);
			chmod("../cms/tmp", 0777);
			chmod("../upload/images", 0777);
			chmod("../upload/photos", 0777);
			chmod("../tmp", 0777);
			chmod("../sitemap.xml", 0777);
			chmod("../config/db.php", 0644);
			
			array_map('unlink', glob("../tmp/*"));
			array_map('unlink', glob("../cms/tmp/*"));
		
			header('location: ../cms');
			die('redirect...');
		}
	}
}
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Kamil Wyremski - wyremski.pl">
	<title><?php echo(lang('The installer script')); ?></title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
	<a href="http://wyremski.pl" title="Creating websites"><img src="../cms/images/cms.png" alt="CMS Kamil Wyremski" id="logo"/></a>
	<h4 class="text-center"><?php echo(lang('Welcome to the installation program! Please fill in the fields below to pre-configure page.')); ?></h4>
	<?php
		if(isset($error)){
			echo('<h3 class="text-danger text-center">'.$error.'</h3>');
		}
	?>
	<br>
	<form method="get" class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-5 control-label"><?php echo(lang('Select language')); ?>:</label>
			<div class="col-sm-7">
				<select class="form-control" name="lang" title="<?php echo(lang('Select language')); ?>" onchange="this.form.submit()">
					<?php
						foreach($list_of_lang as $key=>$lang){
							echo('<option value="'.$lang.'"');
							if($settings['lang']==$lang){
								echo(' selected ');
							}
							echo('>'.$lang.'</option>');
						}
					?>
				</select>
			</div>
		</div>
	</form>
	<br>
	<form method="post" class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-5 control-label"><?php echo(lang('Base URL')); ?></label>
			<div class="col-sm-7">
				<input class="form-control" type="text" name="base_url" placeholder="<?php echo(lang('Base URL')); ?>" value="<?php if(isset($_POST['base_url'])){echo($_POST['base_url']);}else{echo('http://'.$_SERVER['HTTP_HOST']);}?>" required title="<?php echo(lang('Enter Web site address')); ?>"/>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-5 control-label"><?php echo(lang('The database server')); ?>:</label>
			<div class="col-sm-7">
				<input class="form-control" type="text" name="serwer" placeholder="<?php echo(lang('The database server')); ?>" value="<?php if(isset($_POST['serwer'])){echo($_POST['serwer']);}else{echo('localhost');}?>" required title="<?php echo(lang('Enter the address of the database server - default: localhost')); ?>"/>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-5 control-label"><?php echo(lang('The database user name')); ?>:</label>
			<div class="col-sm-7">
				<input class="form-control" type="text" name="user" placeholder="<?php echo(lang('The database user name')); ?>" value="<?php if(isset($_POST['user'])){echo($_POST['user']);}?>" required title="<?php echo(lang('Enter the name of the database user')); ?>"/>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-5 control-label"><?php echo(lang('The database name')); ?>:</label>
			<div class="col-sm-7">
				<input class="form-control" type="text" name="name" placeholder="<?php echo(lang('The database name')); ?>" value="<?php if(isset($_POST['name'])){echo($_POST['name']);}?>" required title="<?php echo(lang('Enter the name of the database')); ?>"/>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-5 control-label"><?php echo(lang('Password for database')); ?>:</label>
			<div class="col-sm-7">
				<input class="form-control" type="password" name="password" placeholder="<?php echo(lang('Password for database')); ?>" value="<?php if(isset($_POST['password'])){echo($_POST['password']);}?>" title="<?php echo(lang('Enter the password to the database')); ?>"/>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-5 control-label"><?php echo(lang('Login to CMS')); ?>:</label>
			<div class="col-sm-7">
				<input class="form-control" type="text" name="user_cms" placeholder="<?php echo(lang('Login to CMS')); ?>" value="<?php if(isset($_POST['user_cms'])){echo($_POST['user_cms']);}else{echo('administrator');}?>" required title="<?php echo(lang('Enter the login which you want to log in to the CMS - default: administrator')); ?>"/>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-5 control-label"><?php echo(lang('Password to CMS')); ?>:</label>
			<div class="col-sm-7">
				<p class="text-danger hide" id="alert_password_diferrent"><?php echo(lang('The passwords are different')); ?></p>
				<input  class="form-control" type="password" name="password_cms" placeholder="<?php echo(lang('Password to CMS')); ?>" value="<?php if(isset($_POST['password_cms'])){echo($_POST['password_cms']);}?>" required title="<?php echo(lang('Enter the password to CMS')); ?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-5 control-label"><?php echo(lang('Repeat password to CMS')); ?>:</label>
			<div class="col-sm-7">
				<input class="form-control" type="password" name="password_cms_repeat" placeholder="<?php echo(lang('Repeat password to CMS')); ?>" required title="<?php echo(lang('Here you enter the password again')); ?>"/>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-5 control-label"><?php echo(lang('E-mail Administrator')); ?>:</label>
			<div class="col-sm-7">
				<input class="form-control" type="email" name="email" placeholder="<?php echo(lang('E-mail Administrator')); ?>" value="<?php if(isset($_POST['email'])){echo($_POST['email']);}?>" title="<?php echo(lang('Enter e-mail the site administrator')); ?>" required/>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-5 control-label"><?php echo(lang('Prefix tables in the database')); ?>:</label>
			<div class="col-sm-7">
				<input class="form-control" type="text" name="db_prefix" placeholder="<?php echo(lang('Prefix tables in the database')); ?>" value="<?php if(isset($_POST['db_prefix'])){echo($_POST['db_prefix']);}?>" title="<?php echo(lang('In cases where multiple sites use the one database you can determine the prefix table, otherwise leave it blank')); ?>" pattern="[a-z_]*"/>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-5 control-label"><?php echo(lang('Salt passwords in the system')); ?>:</label>
			<div class="col-sm-7">
				<input class="form-control" type="text" name="pass_hash" placeholder="<?php echo(lang('Salt passwords in the system')); ?>" value="<?php if(isset($_POST['pass_hash'])){echo($_POST['pass_hash']);}?>" title="<?php echo(lang('Additional security user passwords - enter any string')); ?>"/>
			</div>
		</div>
		<div class="form-group text-center">
			<input class="btn btn-primary" type="submit" value="<?php echo(lang('Save')); ?>"/>
		</div>
	</form>
	<p><?php echo(lang('In case of problems with the installation, change the permissions of the following files and folders on the value of 0777')); ?>:
	<br>/cache
	<br>/cms/cache
	<br>/cms/tmp
	<br>/upload/images
	<br>/upload/photos
	<br>/tmp
	<br>/sitemap.xml
	<br>/config/db.php - <?php echo(lang('in the last file after the installation is completed, change for 0644')); ?></p>
</div>
<footer class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<p class="text-center small">CMS v4 - Project © 2017 by <a href="http://wyremski.pl" target="_blank" title="Web Design">Kamil Wyremski</a></p>
		</div>
	</div>
</footer>
</body>
</html>
