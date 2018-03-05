<?php ob_start(); ?>

	<h2 class="ui teal image header">
		<img src="assets/images/logo.png" class="image">
		<div class="content">
			Log-in to your account
		</div>
	</h2>
	<form class="ui large form">
		<div class="ui stacked segment">
			<div class="field">
				<div class="ui left icon input">
					<i class="user icon"></i>
					<input type="text" name="email" placeholder="E-mail address">
				</div>
			</div>
			<div class="field">
				<div class="ui left icon input">
					<i class="lock icon"></i>
					<input type="password" name="password" placeholder="Password">
				</div>
			</div>
			<div class="ui fluid large teal submit button">Login</div>
		</div>

		<div class="ui error message"></div>
	</form>

	<div class="ui message">
		Déjà un compte ? <a href="<?= $router->generateUri('security.login') ?>">Connecte-toi !</a>
		<br>
		<br>
		<a href="<?= $router->generateUri('home') ?>">Retour au site</a>
	</div>

<?php $layout = ob_get_clean(); ?>

<?= $renderer->renderView('template.security', compact('layout')); ?>