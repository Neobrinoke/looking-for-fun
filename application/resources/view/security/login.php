<?php
/** @var \App\Framework\Support\Collection $errors */
?>

<?php ob_start(); ?>

	<h1 class="ui teal image header">Se connecter</h1>

	<form class="ui large form <?= $errors->any() ? 'error' : '' ?>" action="<?= route('security.loginCheck') ?>" method="POST">
			<div class="ui stacked segment">
				<?= renderView('message.error', ['errors' => $errors->all()]) ?>

			<div class="field <?= $errors->any() ? 'error' : '' ?>">
				<div class="ui left icon input">
					<i class="user icon"></i>
					<input type="text" name="login" placeholder="Identifiant" value="<?= old('login') ?>">
				</div>
			</div>
			<div class="field <?= $errors->any() ? 'error' : '' ?>">
				<div class="ui left icon input">
					<i class="lock icon"></i>
					<input type="password" name="password" placeholder="Mot de passe">
				</div>
			</div>
			<button type="submit" class="ui fluid large teal submit button">Connexion</button>
		</div>
	</form>

	<section class="ui message">
		Nouveau ? <a href="<?= route('security.register') ?>">Enregistez-toi !</a>
		<br>
		<br>
		<a href="<?= route('home') ?>">Retour au site</a>
	</section>

<?php $layout = ob_get_clean(); ?>

<?= renderView('template.security', compact('layout')); ?>