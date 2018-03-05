<?php ob_start(); ?>
	<link rel="stylesheet" href="/css/security.css">
<?php $css = ob_get_clean(); ?>

<?php ob_start(); ?>

	<div class="ui middle aligned center aligned grid">
		<div class="column">
			<?= $layout ?>
		</div>
	</div>

<?php $content = ob_get_clean(); ?>

<?php ob_start(); ?>

<?php $js = ob_get_clean(); ?>

<?= $renderer->renderView('base', compact('content', 'css', 'js')); ?>