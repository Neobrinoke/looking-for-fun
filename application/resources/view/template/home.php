<?php ob_start(); ?>
	<link rel="stylesheet" href="/css/home.css">
	<?php if (isset($css)) echo $css; ?>
<?php $css = ob_get_clean(); ?>

<?php ob_start(); ?>

	<!-- Sidebar Menu -->
	<header class="ui vertical inverted sidebar menu left">
		<a class="item" href="<?= $router->generateUri('home') ?>">Accueil</a>
		<a class="item" href="<?= $router->generateUri('gameGroup.index') ?>">Groupes de jeu</a>
	</header>

	<!-- Page Contents -->
	<div class="pusher">
		<header class="ui inverted vertical masthead center aligned segment" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.8)),url('/img/Wallpaper-Gaming-049.jpg') center center no-repeat;">
			<div class="ui container">
				<div class="ui large secondary inverted pointing menu">
					<a class="toc item">
						<i class="sidebar icon"></i>
					</a>
					<a class="item" href="<?= $router->generateUri('home') ?>">Accueil</a>
					<a class="item" href="<?= $router->generateUri('gameGroup.index') ?>">Groupes de jeu</a>
					<div class="right item">
						<?php if ($auth->isLogged()): ?>
							<a class="ui inverted button" href="#"><?= $auth->user()->getName() ?></a>
							<a class="ui inverted button" href="<?= $router->generateUri('security.logout') ?>">Deconnexion</a>
						<?php else: ?>
							<a class="ui inverted button" href="<?= $router->generateUri('security.login') ?>">Se connecter</a>
							<a class="ui inverted button" href="<?= $router->generateUri('security.register') ?>">S'inscrire</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="ui text container">
				<h1 class="ui inverted header">À la recherche de joueurs ?</h1>
				<h2>Trouve des personnes avec qui jouer !<br>Que ce sois pour le fun ou pour tryhard !</h2>
				<div class="ui huge primary button">Crée un groupe !<i class="right arrow icon"></i></div>
			</div>
		</header>

		<?= $layout ?>

		<?= $renderer->renderView('template.footer') ?>
	</div>

<?php $content = ob_get_clean(); ?>

<?php ob_start(); ?>
	<script src="/js/home.js"></script>
	<?php if (isset($js)) echo $js; ?>
<?php $js = ob_get_clean(); ?>

<?= $renderer->renderView('base', compact('content', 'css', 'js')); ?>