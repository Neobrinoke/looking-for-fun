<?php

namespace App\Framework\Http;

use GuzzleHttp\Psr7\Response as GuzzleResponse;

class Response extends GuzzleResponse
{
	/**
	 * Response constructor.
	 *
	 * @param int $status
	 * @param array $headers
	 * @param null $body
	 * @param string $version
	 * @param null|string $reason
	 */
	public function __construct(int $status = 200, array $headers = [], $body = null, string $version = '1.1', ?string $reason = null)
	{
		parent::__construct($status, $headers, $body, $version, $reason);
	}

	/**
	 * Send response to browser
	 */
	public function send()
	{
		$http_line = sprintf('HTTP/%s %s %s',
			$this->getProtocolVersion(),
			$this->getStatusCode(),
			$this->getReasonPhrase()
		);

		header($http_line, true, $this->getStatusCode());

		foreach ($this->getHeaders() as $name => $values) {
			foreach ($values as $value) {
				header("$name: $value", false);
			}
		}

		$stream = $this->getBody();

		if ($stream->isSeekable()) {
			$stream->rewind();
		}

		while (!$stream->eof()) {
			echo $stream->read(1024 * 8);
		}
	}
}