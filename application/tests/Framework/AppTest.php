<?php

namespace Framework;

use App\Framework\App;
use App\Framework\Router\Router;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
	/**
	 * @throws \Exception
	 */
	public function testRedirectTrailingSlash()
	{
		$app = new App();
		$response = $app->run(new ServerRequest('GET', '/azerty/'));

		$this->assertContains('/azerty', $response->getHeader('Location'));
		$this->assertEquals(301, $response->getStatusCode());
	}

	/**
	 * @throws \Exception
	 */
	public function testUrl()
	{
		$app = new App();

		$app->router->get('/azerty', function () {
			return '<h1>Azerty</h1>';
		}, 'azerty');

		$response = $app->run(new ServerRequest('GET', '/azerty'));

		$this->assertContains('<h1>Azerty</h1>', (string)$response->getBody());
		$this->assertEquals(200, $response->getStatusCode());
	}

	/**
	 * @throws \Exception
	 */
	public function testError404()
	{
		$app = new App();
		$response = $app->run(new ServerRequest('GET', '/azerty'));

		$this->assertContains('<h1>Erreur 404</h1>', (string)$response->getBody());
		$this->assertEquals(404, $response->getStatusCode());
	}
}