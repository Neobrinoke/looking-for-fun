<?php ob_start(); ?>
	<link rel="stylesheet" href="/css/security.css">
<?php $css = ob_get_clean(); ?>

<?php ob_start(); ?>

	<main>
		<?= $layout ?>
	</main>

<?php $content = ob_get_clean(); ?>

<?php ob_start(); ?>

<?php $js = ob_get_clean(); ?>

<?= $renderer->renderView('base', compact('content', 'css', 'js')); ?>