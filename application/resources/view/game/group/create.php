<?php
/** @var \App\Framework\Support\Collection $errors */
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
		<form class="ui form <?= $errors->any() ? 'error' : '' ?>" action="<?= route('gameGroup.store') ?>" method="POST">
			<?= renderView('message.error', ['errors' => $errors->all()]) ?>

			<div class="field <?= $errors->has('name') ? 'error' : '' ?>">
				<label for="name">Nom du group</label>
				<input type="text" id="name" name="name" placeholder="Nom du group" value="<?= old('name') ?>">
			</div>
			<div class="field <?= $errors->has('description') ? 'error' : '' ?>">
				<label for="description">Description</label>
				<textarea id="description" name="description" placeholder="Description du group" cols="30" rows="10"><?= old('description') ?></textarea>
			</div>
			<button class="ui button" type="submit">Créer</button>
		</form>
	</div>


<?php $layout = ob_get_clean(); ?>

<?= renderView('template.layout', compact('layout')); ?>