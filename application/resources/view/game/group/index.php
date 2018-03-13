<?php ob_start(); ?>

	<?php foreach ($gameGroups as $gameGroup): ?>
		<?php var_dump($gameGroup); ?>
	<?php endforeach; ?>

<?php $layout = ob_get_clean(); ?>

<?= $renderer->renderView('template.layout', compact('layout')); ?>