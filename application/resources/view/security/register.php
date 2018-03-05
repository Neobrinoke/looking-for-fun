<?php ob_start(); ?>

	<h2 class="ui teal image header">
		<div class="content">S'enregistrer</div>
	</h2>
	<form class="ui large form" action="<?= $router->generateUri('security.store') ?>" method="POST">
		<div class="ui stacked segment">
			<div class="field">
				<div class="ui left icon input">
					<i class="user icon"></i>
					<input type="text" name="name" placeholder="Pseudo" <?= isset($old['name']) ? 'value="' . $old['name'] . '"' : '' ?>>
				</div>
			</div>
			<div class="field">
				<div class="ui left icon input">
					<i class="user icon"></i>
					<input type="text" name="email" placeholder="Adresse e-mail" <?= isset($old['email']) ? 'value="' . $old['email'] . '"' : '' ?>>
				</div>
			</div>
			<div class="field">
				<div class="ui left icon input">
					<i class="user icon"></i>
					<input type="text" name="login" placeholder="Identifiant" <?= isset($old['login']) ? 'value="' . $old['login'] . '"' : '' ?>>
				</div>
			</div>
			<div class="field">
				<div class="ui left icon input">
					<i class="lock icon"></i>
					<input type="password" name="password" placeholder="Mot de passe">
				</div>
			</div>
			<div class="field">
				<div class="ui left icon input">
					<i class="lock icon"></i>
					<input type="password" name="password_conf" placeholder="Confirmer le mot de passe">
				</div>
			</div>
			<button type="submit" class="ui fluid large teal submit button">S'enregistrer</button>
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