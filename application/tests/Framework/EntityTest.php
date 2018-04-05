<?php

namespace Tests\Framework;

use App\Entity\User;
use App\Framework\Database\PdoAdapter;
use App\Framework\Database\QueryBuilder;
use PDO;
use Phinx\Config\Config;
use Phinx\Migration\Manager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

class EntityTest extends TestCase
{
	/** @var PDO */
	private $pdo;

	public function setUp()
	{
		$this->pdo = (new PdoAdapter(true))->getConnection();

		$configArray = require(__DIR__ . '/../../phinx.php');
		$configArray['environments']['test']['connection'] = $this->pdo;

		$config = new Config($configArray);
		$manager = new Manager($config, new StringInput(' '), new NullOutput());
		$manager->migrate('test');
		$manager->seed('test');
	}

	public function testFind()
	{
		$queryBuilder = (new QueryBuilder($this->pdo))
			->select()
			->field('*')
			->table('users')
			->where('id = :id');

		$queryBuilder->value(1, 'id');

		$user = (new User())->injectEntityProperties($queryBuilder->getResult());

		$this->assertInstanceOf(User::class, $user);
	}
}