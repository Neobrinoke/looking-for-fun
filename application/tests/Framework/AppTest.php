<?php

namespace Framework;

use App\Framework\App;
use App\Framework\Router\Router;
use DI\ContainerBuilder;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class AppTest extends TestCase
{
	/** @var ContainerInterface */
	private $container;

	public function setUp()
	{
		$this->container = (new ContainerBuilder())->build();
	}

	public function testRedirectTrailingSlash()
	{
		$app = new App($this->container);
		$response = $app->run(new ServerRequest('GET', '/azerty/'));

		$this->assertContains('/azerty', $response->getHeader('Location'));
		$this->assertEquals(301, $response->getStatusCode());
	}

	public function testUrl()
	{
		$this->container->get(Router::class)->get('/azerty', function () {
			return '<h1>Azerty</h1>';
		}, 'azerty');

		$app = new App($this->container);
		$response = $app->run(new ServerRequest('GET', '/azerty'));

		$this->assertContains('<h1>Azerty</h1>', (string)$response->getBody());
		$this->assertEquals(200, $response->getStatusCode());
	}

	public function testError404()
	{
		$app = new App($this->container);
		$response = $app->run(new ServerRequest('GET', '/azerty'));

		$this->assertContains('<h1>Erreur 404</h1>', (string)$response->getBody());
		$this->assertEquals(404, $response->getStatusCode());
	}
}