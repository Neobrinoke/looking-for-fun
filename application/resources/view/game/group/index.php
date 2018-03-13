<?php ob_start(); ?>

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
			<?php /** @var \App\Entity\GameGroup $gameGroup */?>
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

<?php $layout = ob_get_clean(); ?>

<?= $renderer->renderView('template.layout', compact('layout')); ?>