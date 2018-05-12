<?php

namespace Tests\Framework;

use App\Framework\App;
use App\Framework\Http\Request;
use App\Framework\Router\Router;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
	public function testRedirectTrailingSlash()
	{
		$app = new App();
		$response = $app->run(new Request('GET', '/azerty/'));

		$this->assertContains('/azerty', $response->getHeader('Location'));
		$this->assertEquals(301, $response->getStatusCode());
	}

	public function testUrl()
	{
		Router::get('/azerty', function () {
			return '<h1>Azerty</h1>';
		}, 'azerty');

		$app = new App();
		$response = $app->run(new Request('GET', '/azerty'));

		$this->assertContains('<h1>Azerty</h1>', (string)$response->getBody());
		$this->assertEquals(200, $response->getStatusCode());
	}

	public function testError404()
	{
		$app = new App();
		$response = $app->run(new Request('GET', '/notexist'));

		$this->assertContains('<h1>Erreur 404</h1>', (string)$response->getBody());
		$this->assertEquals(404, $response->getStatusCode());
	}
}