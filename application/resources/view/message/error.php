<?php
/** @var array $errors */
?>

<div class="ui error message">
	<div class="header">Quelques erreurs restes à corriger</div>
	<ul class="list">
		<?php foreach ($errors as $error): ?>
			<?php if (is_array($error)): ?>
				<?php foreach ($error as $err): ?>
					<li><?= $err ?></li>
				<?php endforeach; ?>
			<?php else: ?>
				<li><?= $error ?></li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
</div>