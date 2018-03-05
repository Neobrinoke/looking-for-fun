<?php

namespace App\Controller;

use App\Framework\Renderer\Renderer;
use GuzzleHttp\Psr7\Response;

class Controller extends Renderer
{
	/**
	 * Send new response
	 *
	 * @param int $status
	 * @param array $headers
	 * @param null|string $body
	 * @return Response
	 */
	protected function response(int $status = 200, array $headers = [], ?string $body = null)
	{
		return new Response($status, $headers, $body);
	}
}