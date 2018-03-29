<?php

namespace App\Controller;

use App\Entity\User;
use App\Framework\Controller\Controller;
use PDO;
use Psr\Http\Message\ServerRequestInterface;

class DefaultController extends Controller
{
	/**
	 * @return \GuzzleHttp\Psr7\Response
	 */
	public function homeAction()
	{
		return $this->renderView('default.default');
	}

	/**
	 * @return \GuzzleHttp\Psr7\Response
	 * @throws \Exception
	 */
	public function testAction()
	{
		$user = User::findOneBy([
			'login' => 'neobrinokeneo'
		]);

		if($user) {
			$user->delete();
		} else {
			echo 'nope';
		}

		return $this->renderView('default.test');
	}

	/**
	 * @param ServerRequestInterface $request
	 * @param $id
	 * @return \GuzzleHttp\Psr7\Response
	 */
	public function storeAction(ServerRequestInterface $request, int $id)
	{
		return $this->renderView('default.test', compact('id'));
	}
}