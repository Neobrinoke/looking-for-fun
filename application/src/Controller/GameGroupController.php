<?php

namespace App\Controller;

use App\Entity\GameGroup;
use App\Entity\GameGroupUser;
use App\Framework\Controller\Controller;
use App\Framework\Http\Request;
use App\Framework\Http\Response;
use App\Framework\Validator\Validator;

class GameGroupController extends Controller
{
	/**
	 * Affiche tous les groupes de jeu
	 *
	 * @param Request $request
	 * @return Response
	 * @throws \Exception
	 */
	public function indexAction(Request $request)
	{
		$gameGroups = GameGroup::all(['created_at DESC']);
		return $this->renderView('game.group.index', compact('gameGroups'));
	}

	/**
	 * Affiche la vue 'create' du groupe
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function createAction(Request $request)
	{
		return $this->renderView('game.group.create');
	}

	/**
	 * Insert le groupe au niveau SQL
	 *
	 * @param Request $request
	 * @return Response
	 * @throws \Exception
	 */
	public function storeAction(Request $request)
	{
		$validator = new Validator($request->getParsedBody(), [
			'name' => 'min:3|max:255|required',
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

		return $this->renderView('game.group.create', compact('errors'));
	}

	/**
	 * Affiche la vue 'show' du groupe
	 *
	 * @param Request $request
	 * @param GameGroup $gameGroup
	 * @return Response
	 */
	public function showAction(Request $request, GameGroup $gameGroup)
	{
		return $this->renderView('game.group.show', compact('gameGroup'));
	}

	/**
	 * Affiche la page 'edit' du groupe
	 *
	 * @param Request $request
	 * @param GameGroup $gameGroup
	 * @return Response
	 */
	public function editAction(Request $request, GameGroup $gameGroup)
	{
		return $this->renderView('game.group.edit', compact('gameGroup'));
	}

	/**
	 * Met à jour le groupe en SQL
	 *
	 * @param Request $request
	 * @param GameGroup $gameGroup
	 * @return Response
	 * @throws \Exception
	 */
	public function updateAction(Request $request, GameGroup $gameGroup)
	{
		$old = $request->getParsedBody();

		$validator = new Validator($request->getParsedBody(), [
			'name' => 'min:3|max:255|required',
			'description' => 'min:15|max:255|required'
		]);

		if ($validator->validate()) {
			$gameGroup->fill($request->getParsedBody());
			$gameGroup->save();
			return $this->redirectToRoute('gameGroup.index');
		}

		$errors = $validator->getErrors();

		return $this->renderView('game.group.edit', compact('old', 'errors', 'gameGroup'));
	}

	/**
	 * Supprime le groupe
	 *
	 * @param Request $request
	 * @param GameGroup $gameGroup
	 * @return Response
	 * @throws \Exception
	 */
	public function deleteAction(Request $request, GameGroup $gameGroup)
	{
		$gameGroup->delete();

		return $this->redirectToRoute('gameGroup.index');
	}

	/**
	 * Rejoin le groupe
	 *
	 * @param Request $request
	 * @param GameGroup $gameGroup
	 * @return Response
	 * @throws \Exception
	 */
	public function joinAction(Request $request, GameGroup $gameGroup)
	{
		$gameGroupUser = new GameGroupUser();
		$gameGroupUser->setGameGroup($gameGroup);
		$gameGroupUser->setUser($this->auth()->user());
		$gameGroupUser->save();

		return $this->redirectToRoute('gameGroup.index');
	}

	/**
	 * Expulse un membre du group
	 *
	 * @param Request $request
	 * @param GameGroup $gameGroup
	 * @param int $userId
	 * @return Response
	 * @throws \Exception
	 */
	public function expelAction(Request $request, GameGroup $gameGroup, int $userId)
	{
		GameGroupUser::findOneBy([
			'user_id' => $userId,
			'game_group_id' => $gameGroup->getId()
		])->delete();

		return $this->redirectToRoute('gameGroup.index');
	}
}