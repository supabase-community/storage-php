<?php

namespace Supabase\Util;

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

	public static function request_file($url, $headers)
	{
		try {
			$file_name = basename($url);
			$httpClient = new \GuzzleHttp\Client();
			$response = $httpClient->get(
				$url,
				[
					\GuzzleHttp\RequestOptions::HEADERS =>$headers,
					\GuzzleHttp\RequestOptions::SINK => $file_name,
				]
			);

			return ['data' => $response, 'error' => null];
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

		return $error;
	}
}
