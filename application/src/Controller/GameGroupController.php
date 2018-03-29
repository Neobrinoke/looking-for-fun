<?php

namespace App\Controller;

use App\Entity\GameGroup;
use App\Framework\Controller\Controller;
use App\Framework\ORM\QueryBuilder;
use App\Framework\Validator\Validator;
use MongoDB\Driver\Query;
use Psr\Http\Message\ServerRequestInterface;

class GameGroupController extends Controller
{
	/**
	 * Affiche tous les groupes de jeu
	 *
	 * @return \GuzzleHttp\Psr7\Response
	 * @throws \Exception
	 */
	public function indexAction()
	{
		$gameGroups = GameGroup::all(['created_at DESC']);
		return $this->renderView('game.group.index', compact('gameGroups'));
	}

	/**
	 * Affiche la vue de création du groupe
	 *
	 * @return \GuzzleHttp\Psr7\Response
	 */
	public function createAction()
	{
		return $this->renderView('game.group.create');
	}

	/**
	 * Insert le groupe au niveau SQL
	 *
	 * @param ServerRequestInterface $request
	 * @return \GuzzleHttp\Psr7\Response
	 * @throws \Exception
	 */
	public function storeAction(ServerRequestInterface $request)
	{
		$old = $request->getParsedBody();

		$validator = new Validator($request->getParsedBody(), [
			'name' => 'min:3|max:15|required',
			'description' => 'min:15|max:255|required'
		]);

		if ($validator->validate()) {
			/** @var GameGroup $gameGroup */
			$gameGroup = GameGroup::generateWithForm($request->getParsedBody());
			$gameGroup->setOwner($this->auth()->user());
			$gameGroup->save();
			return $this->redirectToRoute('gameGroup.index');
		}

		$errors = $validator->getErrors();

		return $this->renderView('game.group.create', compact('old', 'errors'));
	}
}