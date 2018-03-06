<?php ob_start(); ?>

	<h1 class="ui teal image header">Se connecter</h1>

	<form class="ui large form">
		<div class="ui stacked segment">
			<div class="field">
				<div class="ui left icon input">
					<i class="user icon"></i>
					<input type="text" name="login" placeholder="Identifiant ou email">
				</div>
			</div>
			<div class="field">
				<div class="ui left icon input">
					<i class="lock icon"></i>
					<input type="password" name="password" placeholder="Mot de passe">
				</div>
			</div>
			<div class="ui fluid large teal submit button">Connexion</div>
		</div>
	</form>

	<section class="ui message">
		Nouveau ? <a href="<?= $router->generateUri('security.register') ?>">Enregistez-toi !</a>
		<br>
		<br>
		<a href="<?= $router->generateUri('home') ?>">Retour au site</a>
	</section>

<?php $layout = ob_get_clean(); ?>

<?= $renderer->renderView('template.security', compact('layout')); ?>