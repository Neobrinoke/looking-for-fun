<?php ob_start(); ?>

	<h1 class="ui teal image header">S'enregistrer</h1>

	<form class="ui large form <?= !empty($errors) ? 'error' : '' ?>" action="<?= $router->generateUri('security.store') ?>" method="POST">
		<div class="ui stacked segment">
			<div class="ui error message">
				<div class="header">Quelques erreurs restes à corriger</div>
				<ul class="list">
					<?php foreach ($errors as $error): ?>
						<?php if (is_array($error)): ?>
							<?php foreach ($error as $err): ?>
								<li><?= $err ?></li>
							<?php endforeach; ?>
						<?php else: ?>
							<li><?= $error ?></li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="field <?= isset($errors['name']) ? 'error' : '' ?>">
				<div class="ui left icon input">
					<i class="user icon"></i>
					<input type="text" name="name" placeholder="Nom d'utilisateur" <?= isset($old['name']) ? 'value="' . $old['name'] . '"' : '' ?>>
				</div>
			</div>
			<div class="field <?= isset($errors['login']) ? 'error' : '' ?>">
				<div class="ui left icon input">
					<i class="user icon"></i>
					<input type="text" name="login" placeholder="Identifiant" <?= isset($old['login']) ? 'value="' . $old['login'] . '"' : '' ?>>
				</div>
			</div>
			<div class="field <?= isset($errors['email']) ? 'error' : '' ?>">
				<div class="ui left icon input">
					<i class="envelope icon"></i>
					<input type="text" name="email" placeholder="Adresse e-mail" <?= isset($old['email']) ? 'value="' . $old['email'] . '"' : '' ?>>
				</div>
			</div>
			<div class="field <?= isset($errors['password']) ? 'error' : '' ?>">
				<div class="ui left icon input">
					<i class="lock icon"></i>
					<input type="password" name="password" placeholder="Mot de passe">
				</div>
			</div>
			<div class="field <?= isset($errors['password']) ? 'error' : '' ?>">
				<div class="ui left icon input">
					<i class="lock icon"></i>
					<input type="password" name="password_conf" placeholder="Confirmer le mot de passe">
				</div>
			</div>

			<button type="submit" class="ui fluid large teal submit button">Inscription</button>
		</div>
	</form>

	<section class="ui message">
		Déjà un compte ? <a href="<?= $router->generateUri('security.login') ?>">Connecte-toi !</a>
		<br>
		<br>
		<a href="<?= $router->generateUri('home') ?>">Retour au site</a>
	</section>

<?php $layout = ob_get_clean(); ?>

<?= $renderer->renderView('template.security', compact('layout')); ?>