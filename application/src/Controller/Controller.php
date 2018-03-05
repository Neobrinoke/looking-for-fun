<?php

namespace App\Controller;

use App\Framework\Renderer\Renderer;
use GuzzleHttp\Psr7\Response;

class Controller extends Renderer
{
	protected function response(int $status = 200, array $headers = [], ?string $body = null)
	{
		return new Response($status, $headers, $body);
	}
}