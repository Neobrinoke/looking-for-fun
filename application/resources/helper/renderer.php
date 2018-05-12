<?php

/**
 * Render a named view
 *
 * @param string $name
 * @param array $params
 * @return string
 * @throws Exception
 * @throws ReflectionException
 */
function renderView(string $name, array $params = []): string
{
	return app(\App\Framework\Renderer\Renderer::class)->renderView($name, $params);
}