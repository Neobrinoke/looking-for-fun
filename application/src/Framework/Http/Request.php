<?php

namespace App\Framework\Http;

use GuzzleHttp\Psr7\LazyOpenStream;
use GuzzleHttp\Psr7\ServerRequest;

class Request extends ServerRequest
{
	/**
	 * Request constructor.
	 *
	 * @param string $method
	 * @param $uri
	 * @param array $headers
	 * @param null $body
	 * @param string $version
	 * @param array $serverParams
	 */
	public function __construct(string $method, $uri, array $headers = [], $body = null, string $version = '1.1', array $serverParams = [])
	{
		parent::__construct($method, $uri, $headers, $body, $version, $serverParams);
	}

	/**
	 * @return Request
	 * @throws \Exception
	 */
	public static function fromGlobals()
	{
		$method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
		$headers = function_exists('getallheaders') ? getallheaders() : [];
		$uri = self::getUriFromGlobals();
		$body = new LazyOpenStream('php://input', 'r+');
		$protocol = isset($_SERVER['SERVER_PROTOCOL']) ? str_replace('HTTP/', '', $_SERVER['SERVER_PROTOCOL']) : '1.1';

		$request = (new Request($method, $uri, $headers, $body, $protocol, $_SERVER))
			->withCookieParams($_COOKIE)
			->withQueryParams($_GET)
			->withParsedBody($_POST)
			->withUploadedFiles(self::normalizeFiles($_FILES));

		session()->set('old_form', $request->getParsedBody());

		return $request;
	}
}