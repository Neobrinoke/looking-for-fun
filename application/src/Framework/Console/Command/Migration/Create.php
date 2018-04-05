<?php

namespace App\Framework\Console\Command\Migration;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Create extends Command
{
	protected function configure()
	{
		$this->setName('app:create-user');
		$this->setDescription('Creates a new user.');
		$this->setHelp('This command allows you to create a user...');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln([
			'User Creator',
			'============',
			'',
		]);

		$output->writeln('Whoa!');

		$output->write('You are about to ');
		$output->write('create a user.');
	}
}