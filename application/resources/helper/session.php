<?php

/**
 * Return session instance
 *
 * @return \App\Framework\Session\Session|mixed
 * @throws \Psr\Container\ContainerExceptionInterface
 * @throws \Psr\Container\NotFoundExceptionInterface
 */
function session(): \App\Framework\Session\Session
{
	return container()->get(\App\Framework\Session\Session::class);
}