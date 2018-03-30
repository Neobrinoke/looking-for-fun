<?php
/** @var array $errors */
/** @var array $old */
?>

<?php ob_start(); ?>

	<h1 class="ui teal image header">S'enregistrer</h1>

	<form class="ui large form <?= isError($errors) ?>" action="<?= route('security.store') ?>" method="POST">
		<div class="ui stacked segment">
			<?= renderView('message.error', compact('errors')) ?>

			<div class="field <?= isError($errors, 'name') ?>">
				<div class="ui left icon input">
					<i class="user icon"></i>
					<input type="text" name="name" placeholder="Nom d'utilisateur" value="<?= old($old, 'name') ?>">
				</div>
			</div>
			<div class="field <?= isError($errors, 'login') ?>">
				<div class="ui left icon input">
					<i class="user icon"></i>
					<input type="text" name="login" placeholder="Identifiant" value="<?= old($old, 'login') ?>">
				</div>
			</div>
			<div class="field <?= isError($errors, 'email') ?>">
				<div class="ui left icon input">
					<i class="envelope icon"></i>
					<input type="text" name="email" placeholder="Adresse e-mail" value="<?= old($old, 'email') ?>">
				</div>
			</div>
			<div class="field <?= isError($errors, 'password') ?>">
				<div class="ui left icon input">
					<i class="lock icon"></i>
					<input type="password" name="password" placeholder="Mot de passe">
				</div>
			</div>
			<div class="field <?= isError($errors, 'password') ?>">
				<div class="ui left icon input">
					<i class="lock icon"></i>
					<input type="password" name="password_conf" placeholder="Mot de passe (confirmation)">
				</div>
			</div>

			<button type="submit" class="ui fluid large teal submit button">Inscription</button>
		</div>
	</form>

	<section class="ui message">
		Déjà un compte ? <a href="<?= route('security.login') ?>">Connecte-toi !</a>
		<br>
		<br>
		<a href="<?= route('home') ?>">Retour au site</a>
	</section>

<?php $layout = ob_get_clean(); ?>

<?= renderView('template.security', compact('layout')); ?>