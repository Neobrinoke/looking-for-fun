<?php ob_start(); ?>

	<div class="ui vertical stripe segment">
		<div class="ui middle aligned stackable grid container">
			<div class="row">
				<form action="<?= $router->generateUri('test.store', ['id' => $id]) ?>" method="POST">
					<input type="text" name="test"><br>
					<input type="text" name="test2"><br>
					<input type="submit" name="button">
				</form>
			</div>
		</div>
	</div>

<?php $layout = ob_get_clean(); ?>

<?= $renderer->renderView('template.home', compact('layout')); ?>