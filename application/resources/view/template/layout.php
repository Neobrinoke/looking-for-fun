<?php ob_start(); ?>
	<link rel="stylesheet" href="/css/layout.css">
	<?php if (isset($css)) echo $css; ?>
<?php $css = ob_get_clean(); ?>

<?php ob_start(); ?>

	<header class="ui fixed inverted menu">
		<div class="ui container">
			<a href="<?= $router->generateUri('home') ?>" class="header item">Accueil</a>
			<a href="#" class="item">Home</a>
			<div class="ui simple dropdown item">
				Dropdown <i class="dropdown icon"></i>
				<div class="menu">
					<a class="item" href="#">Link Item</a>
					<a class="item" href="#">Link Item</a>
					<div class="divider"></div>
					<div class="header">Header Item</div>
					<div class="item">
						<i class="dropdown icon"></i>
						Sub Menu
						<div class="menu">
							<a class="item" href="#">Link Item</a>
							<a class="item" href="#">Link Item</a>
						</div>
					</div>
					<a class="item" href="#">Link Item</a>
				</div>
			</div>

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

	<main class="ui main text container">
		<div class="ui text container">
			<h1 class="ui inverted header">À la recherche de joueurs ?</h1>
			<h2>Trouve des personnes avec qui jouer !<br>Que ce sois pour le fun ou pour tryhard !</h2>
			<div class="ui huge primary button">Crée un groupe !<i class="right arrow icon"></i></div>
		</div>
		<?= $layout ?>
	</main>

	<?= $renderer->renderView('template.footer') ?>

<?php $content = ob_get_clean(); ?>

<?php ob_start(); ?>
	<?php if (isset($js)) echo $js; ?>
<?php $js = ob_get_clean(); ?>

<?= $renderer->renderView('base', compact('content', 'css', 'js')); ?>