<?php

/**
 * Return router instance
 *
 * @return \App\Framework\Router\Router|mixed
 * @throws \DI\DependencyException
 * @throws \DI\NotFoundException
 */
function router(): \App\Framework\Router\Router
{
	global $container;
	return $container->get(\App\Framework\Router\Router::class);
}

/**
 * Return href for named route
 *
 * @param string $name
 * @param array $params
 * @return string
 * @throws Exception
 * @throws \DI\DependencyException
 * @throws \DI\NotFoundException
 */
function route(string $name, array $params = []): string
{
	return router()->generateUri($name, $params);
}

