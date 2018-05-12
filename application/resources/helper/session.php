<?php

/**
 * Return session instance
 *
 * @return \App\Framework\Session\Session
 * @throws Exception
 * @throws ReflectionException
 */
function session(): \App\Framework\Session\Session
{
	return app(\App\Framework\Session\Session::class);
}