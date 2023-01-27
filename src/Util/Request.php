<?php

namespace Supabase\Util;

use Supabase\Util\StorageError;

class Request
{
    public static function request($method, $url, $headers, $body = null)
    {
        try {
            $request = new \GuzzleHttp\Psr7\Request($method, $url, $headers, $body);
            $client = new \GuzzleHttp\Client();
            $promise = $client->sendAsync($request)->then(function ($response) {
                return json_decode($response->getBody(), true);
            });

            $response = $promise->wait();

            return [ 'data' => $response, 'error' => null ];
        } catch (\Exception $e) {
            throw self::handleError($e);
        }
    }

    public static function request_file($method, $url, $headers, $body = null)
    {
        try {
            $imageFilePath = $path;
            $imageFileResource = fopen($imageFilePath, 'w+');

            $httpClient = new Client();
            $response = $httpClient->get(
                $url,
                [
                    RequestOptions::HEADERS =>$headers,
                    RequestOptions::SINK => $imageFileResource,
                ]
            );

            

            return [ 'data' => $response, 'error' => null ];
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
