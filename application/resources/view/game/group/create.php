<?php ob_start(); ?>

	<?php var_dump($errors); ?>

	<form action="<?= $router->generateUri('gameGroup.store') ?>" method="POST">
		<input type="text" name="name" placeholder="Nom du group">
		<textarea name="description" placeholder="Description du group" cols="30" rows="10"></textarea>
		<button type="submit">Créer</button>
	</form>

<?php $layout = ob_get_clean(); ?>

<?= $renderer->renderView('template.layout', compact('layout')); ?>