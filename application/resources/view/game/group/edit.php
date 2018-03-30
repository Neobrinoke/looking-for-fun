<?php
/** @var \App\Framework\Renderer\Renderer $renderer */
/** @var \App\Framework\Router\Router $router */
/** @var \App\Framework\Session\Session $session */
/** @var \App\Framework\Authentication\Auth $auth */

/** @var array $errors */
/** @var array $old */
/** @var \App\Entity\GameGroup $gameGroup */
?>

<?php ob_start(); ?>

	<div class="ui segment">
		<h2 class="ui header">
			<a class="ui basic button" href="<?= $router->generateUri('gameGroup.index') ?>">
				<i class="left arrow icon"></i>
				Retour à la liste
			</a>
		</h2>
		<div class="ui clearing divider"></div>
		<form class="ui form <?= isError($errors) ?>" action="<?= $router->generateUri('gameGroup.update', compact('gameGroup')) ?>" method="POST">

			<?= $renderer->renderView('message.error', compact('errors')) ?>

			<div class="field <?= isError($errors, 'name') ?>">
				<label for="name">Nom du group</label>
				<input type="text" id="name" name="name" placeholder="Nom du group" value="<?= $gameGroup->getName() ?>">
			</div>
			<div class="field <?= isError($errors, 'description') ?>">
				<label for="description">Description</label>
				<textarea id="description" name="description" placeholder="Description du group" cols="30" rows="10"><?= $gameGroup->getDescription() ?></textarea>
			</div>
			<button class="ui button" type="submit">Modifier</button>
		</form>
	</div>


<?php $layout = ob_get_clean(); ?>

<?= $renderer->renderView('template.layout', compact('layout')); ?>