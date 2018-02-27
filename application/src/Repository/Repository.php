<?php

namespace App\Repository;

use PDO;

class Repository
{
    /** @var PDO */
    protected $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE . ';port=' . DB_PORT . '', DB_USERNAME, DB_PASSWORD);
    }
}