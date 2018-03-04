<?php

namespace Tests\Framework;

use App\Framework\Router\Router;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
	/** @var Router */
	private $router;

	public function setUp()
	{
		$this->router = new Router();
	}

	/**
	 * @throws \Exception
	 */
	public function testGetMethod()
	{
		$request = new ServerRequest('GET', '/groups');

		$this->router->get('/groups', function () {
			return 'hello';
		}, 'groups');

		$route = $this->router->run($request);

		$this->assertEquals('groups', $route->getName());
		$this->assertEquals('hello', call_user_func_array($route->getCallBack(), [$request]));
	}

	/**
	 * @throws \Exception
	 */
	public function testGetMethodIfUrlDoesNotExist()
	{
		$request = new ServerRequest('GET', '/groupsaze');

		$this->router->get('/groups', function () {
			return 'hello';
		}, 'groups');

		$route = $this->router->run($request);

		$this->assertEquals(null, $route);
	}

	/**
	 * @throws \Exception
	 */
	public function testGetMethodWithParameters()
	{
		$request = new ServerRequest('GET', '/group/remove/8');

		$this->router->get('/groups', function () {
			return 'dqsdqsdqas';
		}, 'groups');

		$this->router->get('/group/remove/{id}', function () {
			return 'hello';
		}, 'group.delete');

		$route = $this->router->run($request);

		$this->assertEquals('group.delete', $route->getName());
		$this->assertEquals('hello', call_user_func_array($route->getCallBack(), [$request]));
		$this->assertContains('8', $route->getParams());

		// Test invalid route
		$route = $this->router->run(new ServerRequest('GET', '/group/add'));
		$this->assertEquals(null, $route);
	}

	/**
	 * @throws \Exception
	 */
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