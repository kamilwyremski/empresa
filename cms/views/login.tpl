
<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="login-form panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><span class="glyphicon glyphicon-user"></span> {'Login panel'|lang}</h3>
				</div>
				<form method="post" class="panel-body">
					<a href="http://wyremski.pl" title="Kamil Wyremski - Web Design" target="_blank"><img src="images/cms.png" alt="CMS Logo" class="img-responsive"></a>
					<input type="hidden" name="action" value="login">
					<input type="hidden" name="session_code" value="{$session_code}">
					{if isset($error)}
						<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span> {$error}</div>
					{/if}
					<div class="form-group">
						<label for="username">{'Username'|lang}</label>
						<input type="text" class="form-control" name="username" placeholder="{'Username'|lang}" id="username" required title="{'Username'|lang}">
					</div>
					<div class="form-group">
						<label for="password">{'Password'|lang}</label>
						<input type="password" class="form-control" name="password" placeholder="{'Password'|lang}" id="password" required title="{'Password'|lang}">
					</div>
					<input type="submit" class="btn btn-success btn-block" value="{'Log in'|lang}">
				</form>
			</div>
		</div>
	</div>
</div>

<footer class="container-fluid navbar navbar-fixed-bottom">
	<div class="row">
		<div class="col-md-12">
			<p class="text-center small">CMS v4 - Project © 2017 by <a href="http://wyremski.pl" target="_blank" title="Web Design">Kamil Wyremski</a></p>
		</div>
	</div>
</footer>