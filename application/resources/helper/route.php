<?php

/**
 * Return router instance
 *
 * @return \App\Framework\Router\Router|mixed
 * @throws Exception
 * @throws ReflectionException
 */
function router(): \App\Framework\Router\Router
{
	return app(\App\Framework\Router\Router::class);
}

/**
 * Return href for named route
 *
 * @param string $name
 * @param array $params
 * @return string
 * @throws Exception
 */
function route(string $name, array $params = []): string
{
	return router()->generateUri($name, $params);
}

