<?php

namespace App\Framework\Console\Command\Migration;

use App\Framework\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Create extends Command
{
	protected function configure()
	{
		$this->setName('create:user');
		$this->setDescription('Creates a new user.');
		$this->setHelp('This command allows you to create a user...');
		$this->addArgument('username', InputArgument::REQUIRED, 'The username of the user.');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln([
			'User Creator',
			'============',
			'',
		]);

		$output->writeln('Username: '.$input->getArgument('username'));
	}
}