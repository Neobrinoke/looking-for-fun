<?php

/**
 * Return auth instance
 *
 * @return \App\Framework\Authentication\Auth
 * @throws \Psr\Container\ContainerExceptionInterface
 * @throws \Psr\Container\NotFoundExceptionInterface
 */
function auth(): \App\Framework\Authentication\Auth
{
	return container()->get(\App\Framework\Authentication\Auth::class);
}