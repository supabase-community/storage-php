<?php

namespace Supabase\Storage\Util;

use Psr\Http\Message\ResponseInterface;

class Request
{
	public static function request($method, $url, $headers, $body = null): ResponseInterface
	{
		try {
			$request = new \GuzzleHttp\Psr7\Request($method, $url, $headers, $body);
			$client = new \GuzzleHttp\Client();
			$promise = $client->sendAsync($request)->then(function ($response) {
				return $response;
			});

			$response = $promise->wait();

			return $response;
		} catch (\Exception $e) {
			throw self::handleError($e);
		}
	}

	public static function handleError($error)
	{
		if (method_exists($error, 'getResponse')) {
			$response = $error->getResponse();
			$data = json_decode($response->getBody(), true);
			$error = new StorageApiError($data['message'], intval($data['statusCode']) || 500);
		} else {
			$error = new StorageUnknownError($error->getMessage(), $error->getCode());
		}

		throw $error;
	}
}
