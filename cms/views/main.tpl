<!doctype html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="Keywords" content="CMS, Content Management System">
	<meta name="Description" content="A content management system is a computer application that supports the creation and modification of digital content using a common user interface and thus usually supporting multiple users working in a collaborative environment. Created by Kamil Wyremski - wyremski.pl">
	<meta name="author" content="Kamil Wyremski">
	<title>{$title}</title>
	
	<link rel="stylesheet" href="views/css/bootstrap.min.css">
	<link rel="stylesheet" href="views/css/bootstrap-datepicker.min.css">
	<link rel="stylesheet" href="views/css/style.css">
	<link rel="shortcut icon" href="images/favicon.png"/>
	
	<script src="js/jquery-3.1.1.min.js"></script> 
	<script src="js/bootstrap.min.js"></script> 
	<script src="js/bootstrap-datepicker.min.js"></script> 
	<script src="js/bootstrap-datepicker.pl.min.js"></script> 
	<script src="js/ckeditor/ckeditor.js"></script>
	<script src="js/engine_cms.js"></script>
	<script src="js/whcookies.js"></script>
</head>
<body>

{if $user_cms->logged_in}
<div id="wrapper">
    <nav class="main-nav navbar navbar-default navbar-static-top" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-nav">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="http://wyremski.pl" title="Kamil Wyremski - Web Design" target="_blank" id="logo"><img src="images/cms.png" alt="CMS Logo"></a>
        </div>
        <ul class="nav navbar-top-links navbar-right hidden-xs">
			<li><a href="?module=cms_settings" title="{'CMS settings'|lang}"><span class="glyphicon glyphicon-user"></span> CMS</a></li>
			<li><a href="?logOut" title="{'Log out'|lang}"><span class="glyphicon glyphicon-log-out"></span> {'Log out'|lang}</a></li>
        </ul>
        <div class="navbar-default sidebar" role="navigation" id="left-navigation">
            <div class="sidebar-nav navbar-collapse collapse">
				<ul class="nav" id="side-menu">
					<li {if $module=='index'}class="active"{/if}><a href="{$settings.base_url}/cms" title="{'Home'|lang}"><span class="glyphicon glyphicon-home"></span> {'Home'|lang}</a></li>
					<li {if $module=='statistics'}class="active"{/if}><a href="?module=statistics" title="{'Statistics'|lang}"><span class="glyphicon glyphicon-check"></span> {'Statistics'|lang}</a></li>
					<li {if $module=='offers'}class="active"{/if}><a href="?module=offers" title="{'Offers'|lang}"><span class="glyphicon glyphicon-list-alt"></span> {'Offers'|lang}</a></li>
					<li {if $module=='users'}class="active"{/if}><a href="?module=users" title="{'Users'|lang}"><span class="glyphicon glyphicon-user"></span> {'Users'|lang}</a></li>
					<li>
						<a href="#" data-toggle="collapse" data-target="#submenu_additional" data-parent="#menu" class="collapsed">
							<span class="glyphicon glyphicon-th"></span> {'Additional'|lang} <span class="caret"></span>
						</a>
						<div class="collapse" id="submenu_additional" style="height: 0px;">
							<ul class="nav nav-list">
								<li {if $module=='offers_categories'}class="active"{/if}><a href="?module=offers_categories" title="{'Categories'|lang}">{'Categories'|lang}</a></li>
								<li {if $module=='offers_state'}class="active"{/if}><a href="?module=offers_state" title="{'States'|lang}">{'States'|lang}</a></li>
								<li {if $module=='offers_options'}class="active"{/if}><a href="?module=offers_options" title="{'Additional options'|lang}">{'Additional options'|lang}</a></li>
							</ul>
						</div>
					</li>					
					<li>
						<a href="#" data-toggle="collapse" data-target="#submenu_contents" data-parent="#menu" class="collapsed">
							<span class="glyphicon glyphicon-edit"></span> {'Contents'|lang} <span class="caret"></span>
						</a>
						<div class="collapse" id="submenu_contents" style="height: 0px;">
							<ul class="nav nav-list">
								<li {if $module=='index_page'}class="active"{/if}><a href="?module=index_page" title="{'Index page'|lang}">{'Index page'|lang}</a></li>
								<li {if $module=='mails'}class="active"{/if}><a href="?module=mails" title="{'Mails'|lang}">{'Mails'|lang}</a></li>
								<li {if $module=='info'}class="active"{/if}><a href="?module=info" title="{'Info'|lang}">{'Info'|lang}</a></li>
								<li {if $module=='articles'}class="active"{/if}><a href="?module=articles" title="{'Articles'|lang}">{'Articles'|lang}</a></li>
							</ul>
						</div>
					</li>
					<li>
						<a href="#" data-toggle="collapse" data-target="#submenu_logs" data-parent="#menu" class="collapsed">
							<span class="glyphicon glyphicon-hdd"></span> {'Logs'|lang} <span class="caret"></span>
						</a>
						<div class="collapse" id="submenu_logs" style="height: 0px;">
							<ul class="nav nav-list">
								<li {if $module=='logs_offers'}class="active"{/if}><a href="?module=logs_offers" title="{'Offers'|lang}">{'Offers'|lang}</a></li>
								<li {if $module=='logs_users'}class="active"{/if}><a href="?module=logs_users" title="{'Users'|lang}">{'Users'|lang}</a></li>
								<li {if $module=='logs_mails'}class="active"{/if}><a href="?module=logs_mails" title="{'Mails'|lang}">{'Mails'|lang}</a></li>
								<li {if $module=='reset_password'}class="active"{/if}><a href="?module=reset_password" title="{'Reset password'|lang}">{'Reset password'|lang}</a></li>
							</ul>
						</div>
					</li>	
					<li>
						<a href="#" data-toggle="collapse" data-target="#submenu_logs_payments" data-parent="#menu" class="collapsed">
							<span class="glyphicon glyphicon-eur"></span> {'Logs payments'|lang} <span class="caret"></span>
						</a>
						<div class="collapse" id="submenu_logs_payments" style="height: 0px;">
							<ul class="nav nav-list">
								<li {if $module=='payments_dotpay'}class="active"{/if}><a href="?module=payments_dotpay" title="{'DotPay'|lang}">{'DotPay'|lang}</a></li></a></li>
							</ul>
						</div>
					</li>
					<li>
						<a href="#" data-toggle="collapse" data-target="#submenu_settings" data-parent="#menu" class="collapsed">
							<span class="glyphicon glyphicon-asterisk"></span> {'Settings'|lang} <span class="caret"></span>
						</a>
						<div class="collapse" id="submenu_settings" style="height: 0px;">
							<ul class="nav nav-list">
								<li {if $module=='settings_appearance'}class="active"{/if}><a href="?module=settings_appearance" title="{'Appearance'|lang}">{'Appearance'|lang}</a></li>
								<li {if $module=='settings_social_media'}class="active"{/if}><a href="?module=settings_social_media" title="{'Social Media'|lang}">{'Social Media'|lang}</a></li>
								<li {if $module=='settings_ads'}class="active"{/if}><a href="?module=settings_ads" title="{'Ads'|lang}">{'Ads'|lang}</a></li>
								<li {if $module=='settings_payments'}class="active"{/if}><a href="?module=settings_payments" title="{'Payment settings'|lang}">{'Payment settings'|lang}</a></li>
								<li {if $module=='settings'}class="active"{/if}><a href="?module=settings" title="{'General settings'|lang}">{'General settings'|lang}</a></li>
							</ul>
						</div>
					</li>
					<li class="visible-xs-block"><a href="?module=cms_settings" title="{'CMS settings'|lang}"><span class="glyphicon glyphicon-user"></span> {'CMS settings'|lang}</a></li>
					<li class="visible-xs-block"><a href="?logOut" title="{'Log out'|lang}"><span class="glyphicon glyphicon-log-out"></span> {'Log out'|lang}</a></li>
				</ul>
            </div>
        </div>
    </nav>
    <div id="page-wrapper">
		{if $smarty.const._CMS_TEST_MODE_}<p class="text-danger"><br><br><b>{'Demo version of the CMS. Most of the editing functions are disabled'|lang}</b></p>{/if}
        {include file="$module.html"}
    </div>
</div>

{else}
	{include file="login.tpl"}
{/if}

{include file="cookies.tpl"}

<div class="modal fade" id="roxyCustomPanel" tabindex="-1" role="dialog" aria-labelledby="Select file">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			 <div class="modal-body">
				<iframe frameborder="0" allowtransparency="true"></iframe>
			</div>
		</div>
	</div>
</div>
</body>
</html>
