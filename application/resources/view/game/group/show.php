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
		<div class="ui piled segment">
			<h4 class="ui header"><?= $gameGroup->getName() ?> - Posté par <?= $gameGroup->getOwner()->getName() ?> il y a <?= ago_date_format($gameGroup->getCreatedAt()->format('Y/m/d H:i:s')) ?></h4>
			<p><?= $gameGroup->getDescription() ?></p>
		</div>
		<a href="<?= $router->generateUri('gameGroup.join', compact('gameGroup')) ?>" class="ui primary button">Rejoindre le groupe</a>
	</div>


<?php $layout = ob_get_clean(); ?>

<?= $renderer->renderView('template.layout', compact('layout')); ?>