<?php
/** @var array $errors */
/** @var \App\Entity\GameGroup $gameGroup */
?>

<?php ob_start(); ?>

	<div class="ui segment">
		<h2 class="ui header">
			<a class="ui basic button" href="<?= route('gameGroup.index') ?>">
				<i class="left arrow icon"></i>
				Retour à la liste
			</a>
		</h2>
		<div class="ui clearing divider"></div>
		<div class="ui piled segment">
			<h4 class="ui header"><?= $gameGroup->getName() ?> - Posté par <?= $gameGroup->getOwner()->getName() ?> il y a <?= agoDateFormat($gameGroup->getCreatedAt()->format('Y/m/d H:i:s')) ?></h4>
			<p><?= $gameGroup->getDescription() ?></p>
		</div>
		<a href="<?= route('gameGroup.join', compact('gameGroup')) ?>" class="ui primary button">Rejoindre le groupe</a>
	</div>


<?php $layout = ob_get_clean(); ?>

<?= renderView('template.layout', compact('layout')); ?>