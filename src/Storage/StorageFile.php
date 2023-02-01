<?php

namespace Supabase\Storage;

use Supabase\Util\Constants;
use Supabase\Util\Request;
use Supabase\Util\StorageError;

class StorageFile
{
	protected string $url;
	protected array $headers = [];
	protected string $bucketId;

	protected array $DEFAULT_SEARCH_OPTIONS = [
		'limit' => 100,
		'offset' => 0,
		'sortBy' => [
			'column' => 'name',
			'order' => 'asc',
		],
	];

	protected $DEFAULT_FILE_OPTIONS = [
		'cacheControl' => 3600,
		'upsert' => false,
		'contentType' => 'text/plain;charset=UTF-8',
	];

	public function __construct($url, $headers, $bucketId)
	{
		$this->url = $url;
		$this->headers = array_merge(Constants::getDefaultHeaders(), $headers);
		$this->bucketId = $bucketId;
	}

	/**
	 * Uploads a file to an object storage bucket creating or replacing the file if it already exists.
	 *
	 * @param  string  $method  The HTTP method to use for the request.
	 * @param  string  $path  The path to the file in the bucket.
	 * @param  string  $file  The file to upload.
	 * @param  array  $options  The options for the upload.
	 */
	public function uploadOrUpdate($method, $path, $file, $opts)
	{
		try {
			$options = array_merge($this->DEFAULT_FILE_OPTIONS, $opts);
			$headers = $this->headers;

			if ($method == 'POST') {
				$headers['x-upsert'] = $options['upsert'] ? 'true' : 'false';
			}

			$body = file_get_contents($file);

			$storagePath = $this->_storagePath($path);

			$response = Request::request($method, $this->url.'/object/'.$storagePath, $headers, $body);

			return $response;
		} catch (\Exception $e) {
			if (StorageError::isStorageError($e)) {
				return  ['data' => null, 'error' => $e];
			}

			throw $e;
		}
	}

	/**
	 * Uploads a file to an object storage bucket.
	 *
	 * @param  string  $path  The path to the file in the bucket.
	 * @param  string  $file  The file to upload.
	 * @param  array  $options  The options for the upload.
	 */
	public function upload($path, $file, $opts)
	{
		return $this->uploadOrUpdate('POST', $path, $file, $opts);
	}

	/**
	 * Updates an existing file in the specified bucket.
	 *
	 * @param  string  $path  The path to the file in the bucket.
	 * @param  string  $file  The file to update.
	 * @param  array  $options  The options for the update.
	 */
	public function update($path, $file, $opts)
	{
		return $this->uploadOrUpdate('PUT', $path, $file, $opts);
	}

	/**
	 * Moves a file to a new location in the specified bucket.
	 *
	 * @param  string  $fromPath  The current location of the file.
	 * @param  string  $toPath  The new location of the file.
	 */
	public function move($fromPath, $toPath)
	{
		$headers = $this->headers;
		$headers['content-type'] = 'application/json';
		try {
			$body = [
				'bucketId' => $this->bucketId,
				'sourceKey' => $fromPath,
				'destinationKey' => $toPath,
			];

			$response = Request::request('POST', $this->url.'/object/move', $headers, json_encode($body));

			return [
				'data'=> $response,
				'error'=> null,
			];
		} catch (\Exception $e) {
			if (StorageError::isStorageError($e)) {
				return  ['data' => null, 'error' => $e];
			}

			throw $e;
		}
	}

	/**
	 * Copies a file to a new location in the specified bucket.
	 *
	 * @param  string  $fromPath  The current location of the file.
	 * @param  string  $toPath  The new location of the file.
	 */
	public function copy($fromPath, $toPath)
	{
		$headers = $this->headers;
		$headers['content-type'] = 'application/json';
		try {
			$body = [
				'bucketId' => $this->bucketId,
				'sourceKey' => $fromPath,
				'destinationKey' => $toPath,
			];

			$response = Request::request('POST', $this->url.'/object/copy', $headers, json_encode($body));

			return [
				'data'=> [
					'path' => $response,
				],
				'error' => null,
			];
		} catch (\Exception $e) {
			if (StorageError::isStorageError($e)) {
				return  ['data' => null, 'error' => $e];
			}

			throw $e;
		}
	}

	/**
	 * Creates signed url for limited time sharing of file.
	 *
	 * @param  string  $path  The path to the file to sign.
	 * @param  number  $expiresIn  The time in seconds before the signed url expires.
	 * @param  array  $opts  The options for the signed url.
	 */
	public function createSignedUrl($path, $expires, $opts)
	{
		$headers = $this->headers;
		$headers['content-type'] = 'application/json';

		try {
			$body = [
				'expiresIn' => $expires,
			];
			$storagePath = $this->_storagePath($path);
			$fullUrl = $this->url.'/object/sign/'.$storagePath;
			$response = Request::request('POST', $fullUrl, $headers, json_encode($body));
			$downloadQueryParam = isset($opts['download']) ? '?download=true' : '';
			$signedUrl = urlencode($this->url.$response['data']['signedURL'].$downloadQueryParam);

			return [
				'data'=> ['signedUrl' => $signedUrl],
				'error'=> null,
			];
		} catch (\Exception $e) {
			if (StorageError::isStorageError($e)) {
				return  ['data' => null, 'error' => $e];
			}

			throw $e;
		}
	}

	/**
	 * Creates signed urls for limited time sharing of files.
	 *
	 * @param  string  $paths  The path(s) to the files to sign.
	 * @param  number  $expiresIn  The time in seconds before the signed url expires.
	 * @param  array  $opts  The options for the signed url.
	 */
	public function createSignedUrls($paths, $expiresIn, $opts)
	{
		try {
			$body = [
				'paths'=> $paths,
				'expires_in'=> $expiresIn,
			];
			$fullUrl = $this->url.'/object/sign'.$this->bucketId;
			$response = Request::request('POST', $fullUrl, $this->headers, $opts, $body);

			$downloadQueryParam = $opts['download'] ? '?download=true' : '';

			$signedUrls = array_map(function ($d) {
				$d['signed_url'] = urlencode($this->url.$d['signed_url'].$downloadQueryParam);

				return $d;
			}, $response);

			return [
				'data'=> $signedUrls,
				'error'=> null,
			];
		} catch (\Exception $e) {
			if (StorageError::isStorageError($e)) {
				return  ['data' => null, 'error' => $e];
			}

			throw $e;
		}
	}

	/**
	 * Downloads a file from a private bucket. For public buckets, make a request to the URL returned from `getPublicUrl` instead.
	 *
	 * @param  string  $path  The full path and file name of the file to be downloaded. For example `folder/image.png`.
	 * @param  array  $options  Transform the asset before serving it to the client.
	 */
	public function download($path, $options)
	{
		$headers = $this->headers;
		$url = $this->url.'/object/'.$this->bucketId.'/'.$path;
		$headers['stream'] = true;

		try {
			$response = Request::request_file($url, $headers);

			return $response;
		} catch (\Exception $e) {
			if (StorageError::isStorageError($e)) {
				return  ['data' => null, 'error' => $e];
			}

			throw $e;
		}
	}

	/**
	 * Returns public url for specified file.
	 *
	 * @param  string  $path  The path to the file in the bucket.
	 * @param  string  $opts  The options for getting the public url.
	 */
	public function getPublicUrl($path, $opts)
	{
		$storagePath = $this->_storagePath($path);
		$downloadQueryParam = isset($opts['download']) ? '?download=true' : '';

		return [
			'data' => [
				'publicUrl' => urlencode($this->url.'/object/public/'.$storagePath.$downloadQueryParam),
			],
		];
	}

	/**
	 * Removes a file from an object storage bucket.
	 *
	 * @param  string  $path  The path to the file in the bucket.
	 */
	public function remove($paths)
	{
		$headers = $this->headers;
		$headers['content-type'] = 'application/json';
		try {
			$options = ['prefixes' => $paths];
			$fullUrl = $this->url.'/object/'.$this->bucketId;
			$response = Request::request('DELETE', $fullUrl, $headers, json_encode($options));

			return $response;
		} catch (\Exception $e) {
			if (StorageError::isStorageError($e)) {
				return  ['data' => null, 'error' => $e];
			}

			throw $e;
		}
	}

	/**
	 * Cleans up the path to the file in the bucket.
	 *
	 * @param  string  $path  The path to the file in the bucket.
	 */
	private function _storagePath($path)
	{
		$p = preg_replace('/^\/|\/$/', '', $path);
		$p = preg_replace('/\/+/', '/', $p);

		return $this->bucketId.'/'.$p;
	}
}
