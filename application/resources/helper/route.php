<?php

/**
 * Return router instance
 *
 * @return \App\Framework\Router\Router|mixed
 * @throws \Psr\Container\ContainerExceptionInterface
 * @throws \Psr\Container\NotFoundExceptionInterface
 */
function router(): \App\Framework\Router\Router
{
	return container()->get(\App\Framework\Router\Router::class);
}

/**
 * Return href for named route
 *
 * @param string $name
 * @param array $params
 * @return string
 * @throws Exception
 * @throws \Psr\Container\ContainerExceptionInterface
 * @throws \Psr\Container\NotFoundExceptionInterface
 */
function route(string $name, array $params = []): string
{
	return router()->generateUri($name, $params);
}

