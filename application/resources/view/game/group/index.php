<?php
/** @var \App\Framework\Renderer\Renderer $renderer */
/** @var \App\Framework\Router\Router $router */
/** @var \App\Framework\Session\Session $session */
/** @var \App\Framework\Authentication\Auth $auth */

/** @var array $gameGroups */
/** @var \App\Entity\GameGroup $gameGroup */
?>

<?php ob_start(); ?>

	<div class="ui segment">
		<h2 class="ui header">
			<a class="ui basic button" href="<?= $router->generateUri('gameGroup.create') ?>">
				<i class="icon add"></i>
				Créer un nouveau groupe de jeu
			</a>
		</h2>
		<div class="ui clearing divider"></div>
		<table class="ui celled table">
			<thead>
				<tr>
					<th>Nom</th>
					<th>Description</th>
					<th>Auteur</th>
					<th>Crée le ...</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($gameGroups as $gameGroup): ?>
					<tr>
						<td><?= $gameGroup->getName() ?></td>
						<td><?= $gameGroup->getDescription() ?></td>
						<td><?= $gameGroup->getOwner()->getName() ?></td>
						<td><?= $gameGroup->getCreatedAt()->format('Y/m/d H:i:s') ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>

<?php $layout = ob_get_clean(); ?>

<?= $renderer->renderView('template.layout', compact('layout')); ?>