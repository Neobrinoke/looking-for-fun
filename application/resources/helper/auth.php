<?php

/**
 * Return auth instance
 *
 * @return \App\Framework\Authentication\Auth
 * @throws \DI\DependencyException
 * @throws \DI\NotFoundException
 */
function auth(): \App\Framework\Authentication\Auth
{
	global $container;
	return $container->get(\App\Framework\Authentication\Auth::class);
}