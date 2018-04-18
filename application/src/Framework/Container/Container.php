<?php

namespace App\Framework\Container;

class Container extends \DI\Container
{
	/** @var Container */
	protected static $instance = null;

	/**
	 * Retrieve instance of the current container
	 *
	 * @return Container
	 */
	public static function instance(): Container
	{
		if (is_null(static::$instance)) {
			static::$instance = new static;
		}

		return static::$instance;
	}
}