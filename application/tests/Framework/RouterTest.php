<?php

namespace Tests\Framework;

use App\Framework\Router\Router;
use DI\ContainerBuilder;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

class RouterTest extends TestCase
{
	/** @var Router */
	private $router;

	/** @var ContainerInterface */
	private $container;

	public function setUp()
	{
		$this->container = (new ContainerBuilder())->build();
		$this->router = $this->container->get(Router::class);
	}

	public function testGetMethod()
	{
		$request = new ServerRequest('GET', '/groups');

		$this->router->get('/groups', function () {
			return 'hello';
		}, 'groups');

		$route = $this->router->run($request);

		$this->assertEquals('groups', $route->getName());
		$this->assertEquals('hello', $route->call($this->container, $request->getUri()->getPath()));
	}

	public function testGetMethodIfUrlDoesNotExist()
	{
		$request = new ServerRequest('GET', '/groupsaze');

		$this->router->get('/groups', function () {
			return 'hello';
		}, 'groups');

		$route = $this->router->run($request);

		$this->assertEquals(null, $route);
	}

	public function testGetMethodWithParameters()
	{
		$request = new ServerRequest('GET', '/group/remove/8');

		$this->router->get('/groups', function () {
			return 'dqsdqsdqas';
		}, 'groups');

		$this->router->get('/group/remove/{id}', function (ServerRequestInterface $request, int $id) {
			return 'hello ' . $id;
		}, 'group.delete');

		$route = $this->router->run($request);

		$this->assertEquals('group.delete', $route->getName());
		$this->assertEquals('hello 8', $route->call($this->container, $request->getUri()->getPath()));
		$this->assertContains('8', $route->getParams());

		// Test invalid route
		$route = $this->router->run(new ServerRequest('GET', '/group/add'));
		$this->assertEquals(null, $route);
	}

	public function testGenerateUri()
	{
		$this->router->get('/groups', function () {
			return 'dqsdqsdqas';
		}, 'groups');

		$this->router->get('/group/{id}', function () {
			return 'hello';
		}, 'group.show');

		$uri = $this->router->generateUri('group.show', ['id' => 18]);

		$this->assertEquals('/group/18', $uri);
	}
}