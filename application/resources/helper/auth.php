<?php

/**
 * Return auth instance
 *
 * @return \App\Framework\Authentication\Auth
 * @throws Exception
 * @throws ReflectionException
 */
function auth(): \App\Framework\Authentication\Auth
{
	return app(\App\Framework\Authentication\Auth::class);
}