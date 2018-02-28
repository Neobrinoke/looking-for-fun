<?php

namespace App\Controller;

use App\Entity\AccountGame;
use App\Entity\GameGroupUser;
use App\Entity\GroupGame;
use App\Entity\User;
use App\Repository\GameAccountRepository;
use App\Repository\UserRepository;

class Controller
{
    public function indexAction()
    {
        $oUserRepository = new UserRepository();
        $user = $oUserRepository->findById(1);
        var_dump($user);

        $gameAccountRepository = new GameAccountRepository();
        $gameAccount = $gameAccountRepository->findById(1);
        var_dump($gameAccount);
    }
}