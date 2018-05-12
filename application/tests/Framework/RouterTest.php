<?php

namespace Tests\Framework;

use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class RouterTest extends TestCase
{
	public function testGetMethod()
	{
		$request = new ServerRequest('GET', '/groups');

		router()->get('/groups', function () {
			return 'hello';
		}, 'groups');

		$route = router()->run($request);

		$this->assertEquals('groups', $route->getName());
		$this->assertEquals('hello', $route->call($request->getUri()->getPath()));
	}

	public function testGetMethodIfUrlDoesNotExist()
	{
		$request = new ServerRequest('GET', '/groupsaze');

		router()->get('/groups', function () {
			return 'hello';
		}, 'groups');

		$route = router()->run($request);

		$this->assertEquals(null, $route);
	}

	public function testGetMethodWithParameters()
	{
		$request = new ServerRequest('GET', '/group/remove/8');

		router()->get('/groups', function () {
			return 'dqsdqsdqas';
		}, 'groups');

		router()->get('/group/remove/{id}', function (ServerRequestInterface $request, int $id) {
			return 'hello ' . $id;
		}, 'group.delete');

		$route = router()->run($request);

		$this->assertEquals('group.delete', $route->getName());
		$this->assertEquals('hello 8', $route->call($request->getUri()->getPath()));
		$this->assertContains('8', $route->getParams());

		// Test invalid route
		$route = router()->run(new ServerRequest('GET', '/group/add'));
		$this->assertEquals(null, $route);
	}

	public function testGenerateUri()
	{
		router()->get('/groups', function () {
			return 'dqsdqsdqas';
		}, 'groups');

		router()->get('/group/{id}', function () {
			return 'hello';
		}, 'group.show');

		$uri = router()->generateUri('group.show', ['id' => 18]);

		$this->assertEquals('/group/18', $uri);
	}
}