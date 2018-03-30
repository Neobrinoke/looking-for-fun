<?php
/** @var \App\Entity\GameGroup[] $gameGroups */
?>

<?php ob_start(); ?>

	<div class="ui segment">
		<h2 class="ui header">
			<a class="ui basic button" href="<?= route('gameGroup.create') ?>">
				<i class="icon add"></i>
				Créer un nouveau groupe de jeu
			</a>
		</h2>
		<div class="ui clearing divider"></div>
		<?php if (empty($gameGroups)): ?>
			<div class="ui warning message">
				<p>Aucun groupe de jeu disponible actuellement.</p>
				<p>Cliquez <a href="<?= route('gameGroup.create') ?>">ici</a> pour en créer un.</p>
			</div>
		<?php else: ?>
			<div class="ui cards">
				<?php foreach ($gameGroups as $gameGroup): ?>
					<div class="card">
						<div class="content">
							<img class="right floated mini ui image" src="https://semantic-ui.com/images/avatar/large/elliot.jpg">
							<div class="header"><?= $gameGroup->getName() ?></div>
							<div class="meta">Ajouté par <?= $gameGroup->getOwner()->getName() ?>, <?= ago_date_format($gameGroup->getCreatedAt()->format('Y/m/d H:i:s')) ?></div>
							<div class="description"><?= $gameGroup->getDescription() ?></div>
						</div>
						<div class="extra content">
							<div class="ui fluid center vertical buttons">
								<?php if (auth()->isLogged() && auth()->user()->getId() == $gameGroup->getOwner()->getId()): ?>
									<a href="<?= route('gameGroup.edit', compact('gameGroup')) ?>" class="ui blue button">Editer</a>
									<a href="<?= route('gameGroup.delete', compact('gameGroup')) ?>" class="ui red button">Supprimer</a>
								<?php else: ?>
									<a href="<?= route('gameGroup.join', compact('gameGroup')) ?>" class="ui green button">Postuler</a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>

<?php $layout = ob_get_clean(); ?>

<?= renderView('template.layout', compact('layout')); ?>