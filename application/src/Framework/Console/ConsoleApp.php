<?php

namespace App\Framework\Console;

use App\Framework\Console\Command;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleApp extends Application
{
	/**
	 * Class Constructor.
	 *
	 * Initialize the Phinx console application.
	 */
	public function __construct()
	{
		parent::__construct('Console application');

		$this->addCommands([
			new Command\Migration\Create()
		]);
	}

	/**
	 * Runs the current application.
	 *
	 * @param \Symfony\Component\Console\Input\InputInterface $input An Input instance
	 * @param \Symfony\Component\Console\Output\OutputInterface $output An Output instance
	 * @return int 0 if everything went fine, or an error code
	 * @throws \Throwable
	 */
	public function doRun(InputInterface $input, OutputInterface $output)
	{
		// always show the version information except when the user invokes the help
		// command as that already does it
		if ($input->hasParameterOption(['--help', '-h']) === false && $input->getFirstArgument() !== null) {
			$output->writeln($this->getLongVersion());
			$output->writeln('');
		}

		return parent::doRun($input, $output);
	}
}