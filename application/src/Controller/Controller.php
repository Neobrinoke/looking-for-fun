<?php

namespace App\Controller;

use App\Entity\AccountGame;
use App\Entity\GameAccount;
use App\Entity\GameGroup;
use App\Entity\GameGroupUser;
use App\Entity\GroupGame;
use App\Entity\User;
use App\Repository\GameAccountRepository;
use App\Repository\UserRepository;

class Controller
{
	protected function renderView(string $view, array $params = []): string
	{
		ob_start();
		extract($params);
		include(__DIR__ . '/../../resources/view/' . str_replace('.', '/', $view) . '.php');
		return ob_get_clean();

	}

	public function indexAction($a, $b)
	{
		return $this->renderView('default.default', compact('a', 'b'));
	}
}