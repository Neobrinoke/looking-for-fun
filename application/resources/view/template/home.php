<?php ob_start(); ?>

	<div class="ui large top fixed hidden menu">
		<div class="ui container">
			<a class="active item">Home</a>
			<a class="item">Work</a>
			<a class="item">Company</a>
			<a class="item">Careers</a>
			<div class="right menu">
				<div class="item">
					<a class="ui button">Log in</a>
				</div>
				<div class="item">
					<a class="ui primary button">Sign Up</a>
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
		<a class="item">Login</a>
		<a class="item">Signup</a>
	</div>


	<!-- Page Contents -->
	<div class="pusher">

		<?= $container ?>

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

<?php $layout = ob_get_clean(); ?>
<?= $renderer->renderView('base', compact('layout')); ?>