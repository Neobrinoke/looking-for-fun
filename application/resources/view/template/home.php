<?php ob_start(); ?>
	<link rel="stylesheet" href="/css/home.css">
	<?php if(isset($css)) echo $css; ?>
<?php $css = ob_get_clean(); ?>

<?php ob_start(); ?>

	<div class="ui large top fixed hidden menu">
		<div class="ui container">
			<a class="active item">Home</a>
			<a class="item">Work</a>
			<a class="item">Company</a>
			<a class="item">Careers</a>
			<div class="right menu">
				<div class="item">
					<a class="ui button" href="<?= $router->generateUri('security.login') ?>">Se connecter</a>
				</div>
				<div class="item">
					<a class="ui primary button" href="<?= $router->generateUri('security.register') ?>">S'inscrire</a>
				</div>
			</div>
		</div>
	</div>

	<!-- Sidebar Menu -->
	<div class="ui vertical inverted sidebar menu left">
		<a class="active item">Home</a>
		<a class="item">Work</a>
		<a class="item">Company</a>
		<a class="item">Careers</a>
		<a class="item" href="<?= $router->generateUri('security.login') ?>">Se connecter</a>
		<a class="item" href="<?= $router->generateUri('security.register') ?>">S'inscrire</a>
	</div>


	<!-- Page Contents -->
	<div class="pusher">

		<div class="ui inverted vertical masthead center aligned segment"
			 style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.8)),url('/img/Wallpaper-Gaming-049.jpg') center center no-repeat;">
			<div class="ui container">
				<div class="ui large secondary inverted pointing menu">
					<a class="toc item">
						<i class="sidebar icon"></i>
					</a>
					<a class="active item">Home</a>
					<a class="item">Work</a>
					<a class="item">Company</a>
					<a class="item">Careers</a>
					<div class="right item">
						<a class="ui inverted button" href="<?= $router->generateUri('security.login') ?>">Se connecter</a>
						<a class="ui inverted button" href="<?= $router->generateUri('security.register') ?>">S'inscrire</a>
					</div>
				</div>
			</div>
			<div class="ui text container">
				<h1 class="ui inverted header">À la recherche de joueurs ?</h1>
				<h2>Trouve des personnes avec qui jouer !<br>Que ce sois pour le fun ou pour tryhard !</h2>
				<div class="ui huge primary button">Crée un groupe !<i class="right arrow icon"></i></div>
			</div>
		</div>

		<?= $layout ?>

		<div class="ui inverted vertical footer segment">
			<div class="ui container">
				<div class="ui stackable inverted divided equal height stackable grid">
					<div class="three wide column">
						<h4 class="ui inverted header">About</h4>
						<div class="ui inverted link list">
							<a href="#" class="item">Sitemap</a>
							<a href="#" class="item">Contact Us</a>
							<a href="#" class="item">Religious Ceremonies</a>
							<a href="#" class="item">Gazebo Plans</a>
						</div>
					</div>
					<div class="three wide column">
						<h4 class="ui inverted header">Services</h4>
						<div class="ui inverted link list">
							<a href="#" class="item">Banana Pre-Order</a>
							<a href="#" class="item">DNA FAQ</a>
							<a href="#" class="item">How To Access</a>
							<a href="#" class="item">Favorite X-Men</a>
						</div>
					</div>
					<div class="seven wide column">
						<h4 class="ui inverted header">Footer Header</h4>
						<p>Extra space for a call to action inside the footer that could help re-engage users.</p>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php $content = ob_get_clean(); ?>

<?php ob_start(); ?>
	<script src="/js/home.js"></script>
	<?php if(isset($js)) echo $js; ?>
<?php $js = ob_get_clean(); ?>

<?= $renderer->renderView('base', compact('content', 'css', 'js')); ?>