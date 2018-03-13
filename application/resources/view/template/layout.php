<?php ob_start(); ?>
	<link rel="stylesheet" href="/css/layout.css">
	<?php if (isset($css)) echo $css; ?>
<?php $css = ob_get_clean(); ?>

<?php ob_start(); ?>

	<header class="ui fixed inverted menu">
		<div class="ui container">
			<a href="<?= $router->generateUri('home') ?>" class="header item">Accueil</a>
			<a href="<?= $router->generateUri('gameGroup.index') ?>" class="item">Groupes</a>
			<div class="right menu">
				<?php if ($auth->isLogged()): ?>
					<a class="item" href="#"><?= $auth->user()->getName() ?></a>
					<a class="item" href="<?= $router->generateUri('security.logout') ?>">Deconnexion</a>
				<?php else: ?>
					<a class="item" href="<?= $router->generateUri('security.login') ?>">Se connecter</a>
					<a class="item" href="<?= $router->generateUri('security.register') ?>">S'inscrire</a>
				<?php endif; ?>
			</div>
		</div>
	</header>

	<main class="ui container">
		<?= $layout ?>
	</main>

	<?= $renderer->renderView('template.footer') ?>

<?php $content = ob_get_clean(); ?>

<?php ob_start(); ?>
	<?php if (isset($js)) echo $js; ?>
<?php $js = ob_get_clean(); ?>

<?= $renderer->renderView('base', compact('content', 'css', 'js')); ?>