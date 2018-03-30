<?php
/** @var \App\Framework\Renderer\Renderer $renderer */
/** @var \App\Framework\Router\Router $router */
/** @var \App\Framework\Session\Session $session */
/** @var \App\Framework\Authentication\Auth $auth */
?>

<?php ob_start(); ?>
	<link rel="stylesheet" href="/css/layout.css">
	<?php if (isset($css)) echo $css; ?>
<?php $css = ob_get_clean(); ?>

<?php ob_start(); ?>

	<header class="ui fixed inverted menu">
		<div class="ui container">
			<a href="<?= route('home') ?>" class="header item">Accueil</a>
			<a href="<?= route('gameGroup.index') ?>" class="item">Groupes</a>
			<div class="right menu">
				<?php if (auth()->isLogged()): ?>
					<a class="item" href="#"><?= auth()->user()->getName() ?></a>
					<a class="item" href="<?= route('security.logout') ?>">Deconnexion</a>
				<?php else: ?>
					<a class="item" href="<?= route('security.login') ?>">Se connecter</a>
					<a class="item" href="<?= route('security.register') ?>">S'inscrire</a>
				<?php endif; ?>
			</div>
		</div>
	</header>

	<main class="ui container">
		<?= $layout ?>
	</main>

	<?= renderView('template.footer') ?>

<?php $content = ob_get_clean(); ?>

<?php ob_start(); ?>
	<?php if (isset($js)) echo $js; ?>
<?php $js = ob_get_clean(); ?>

<?= renderView('base', compact('content', 'css', 'js')); ?>