<?php

/**
 * Return session instance
 *
 * @return \App\Framework\Session\Session|mixed
 * @throws \DI\DependencyException
 * @throws \DI\NotFoundException
 */
function session(): \App\Framework\Session\Session
{
	global $container;
	return $container->get(\App\Framework\Session\Session::class);
}