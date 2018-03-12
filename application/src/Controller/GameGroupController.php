<?php

namespace App\Controller;

use App\Entity\GameGroup;
use App\Framework\Controller\Controller;
use App\Framework\Validator\Validator;
use Psr\Http\Message\ServerRequestInterface;

class GameGroupController extends Controller
{
	/**
	 * Affiche tous les groupes de jeu
	 *
	 * @return \GuzzleHttp\Psr7\Response
	 * @throws \Exception
	 * @throws \ReflectionException
	 */
	public function indexAction()
	{
		$gameGroups = GameGroup::all();
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
		$validator = new Validator($request->getParsedBody(), [
			'name' => 'min:3|max:15|required',
			'description' => 'min:15|max:255|required'
		]);

		$errors = $validator->validate();

		if (empty($errors)) {
			/** @var GameGroup $gameGroup */
			$gameGroup = GameGroup::generateWithForm($request->getParsedBody());
			$gameGroup->setOwner($this->auth()->user());
			$gameGroup->save();
			return $this->redirectToRoute('gameGroup.index');
		}

		return $this->renderView('game.group.create', compact('errors'));
	}
}