<?php

/**
 * Render a named view
 *
 * @param string $name
 * @param array $params
 * @return string
 * @throws \DI\DependencyException
 * @throws \DI\NotFoundException
 */
function renderView(string $name, array $params = []): string
{
	global $container;
	return $container->get(\App\Framework\Renderer\Renderer::class)->renderView($name, $params);
}