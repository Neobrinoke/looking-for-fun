<?php

/**
 * Render a named view
 *
 * @param string $name
 * @param array $params
 * @return string
 * @throws \Psr\Container\ContainerExceptionInterface
 * @throws \Psr\Container\NotFoundExceptionInterface
 */
function renderView(string $name, array $params = []): string
{
	return container()->get(\App\Framework\Renderer\Renderer::class)->renderView($name, $params);
}