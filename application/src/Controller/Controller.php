<?php

namespace App\Controller;

use App\Entity\User;

class Controller
{
    public function indexAction()
    {
        $user = new User();

        var_dump($user);

        $user->create();

        return null;
    }
}