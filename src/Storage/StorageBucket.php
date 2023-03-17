<?php

/**
 * A PHP  class  client library to interact with Supabase Storage.
 *
 * Provides functions for handling storage buckets.
 *
 * @author    Zero Copy Labs
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace Supabase\Storage;

use Psr\Http\Message\ResponseInterface;
use Supabase\Util\Constants;
use Supabase\Util\Request;

class StorageBucket
{
	/**
	 * A RESTful endpoint for querying and managing your database.
	 *
	 * @var string
	 */
	protected string $url;

	/**
	 * A header Bearer Token generated by the server in response to a login request
	 * [service key, not anon key].
	 *
	 * @var array
	 */
	protected array $headers = [];

	/**
	 * Get the url.
	 */
	public function __getUrl(): string
	{
		return $this->url;
	}

	/**
	 * Get the headers.
	 */
	public function __getHeaders(): array
	{
		return $this->headers;
	}

	/**
	 * StorageBucket constructor.
	 * 
	 * @param string $api_key The anon or service role key
	 * @param string $reference_id Reference ID
	 * @param string $domain The domain pointing to api
	 * @param string $scheme The api sheme
	 * @param string $path The path to api
	 * 
	 * @throws Exception
	 */
	public function __construct($api_key, $reference_id, $domain = 'supabase.co', $scheme = 'https', $path = '/storage/v1')
	{
		$headers = ['Authorization' => "Bearer {$api_key}"];
		$this->url = ! empty($reference_id) ? "{$scheme}://{$reference_id}.{$domain}{$path}" : "{$scheme}://{$domain}{$path}";
		$this->headers = array_merge(Constants::getDefaultHeaders(), $headers);
	}

	public function __request($method, $url, $headers, $body = null): ResponseInterface
	{
		return Request::request($method, $url, $headers, $body);
	}

	/**
	 * Creates a new Storage bucket.
	 *
	 * @param  string  $bucketId  The bucketId to create.
	 * @param  array  $options  The visibility of the bucket. Public buckets don't require an
	 *                          authorization token to download objects, but still require a valid token for all
	 *                          other operations. By default, buckets are private.
	 * @return ResponseInterface
	 *
	 * @throws Exception
	 */
	public function createBucket($bucketId, $options): ResponseInterface
	{
		$body = json_encode([
			'name' => $bucketId,
			'id' => $bucketId,
			'public' => $options['public'] ? 'true' : 'false',
		]);
		$url = $this->url.'/bucket';
		$headers = array_merge($this->headers, ['Content-Type' => 'application/json']);
		try {
			$data = $this->__request('POST', $url, $headers, $body);

			return $data;
		} catch (\Exception $e) {
			throw $e;
		}
	}

	/**
	 * Retrieves the details of an existing Storage bucket.
	 *
	 * @param  string  $bucketId  The unique identifier of the bucket you
	 *                            would like to retrieve.
	 * @return ResponseInterface
	 *
	 * @throws Exception
	 */
	public function getBucket($bucketId): ResponseInterface
	{
		try {
			$url = $this->url.'/bucket/'.$bucketId;
			$headers = array_merge($this->headers, ['Content-Type' => 'application/json']);
			$data = $this->__request('GET', $url, $headers);

			return $data;
		} catch (\Exception $e) {
			throw $e;
		}
	}

	/**
	 * Retrieves the details of all Storage buckets within an existing project.
	 *
	 * @return ResponseInterface
	 *
	 * @throws Exception
	 */
	public function listBuckets(): ResponseInterface
	{
		$url = $this->url.'/bucket';
		$headers = array_merge($this->headers, ['Content-Type' => 'application/json']);
		try {
			$data = $this->__request('GET', $url, $headers);

			return $data;
		} catch (\Exception $e) {
			throw $e;
		}
	}

	/**
	 * Updates a Storage bucket.
	 *
	 * @param  string  $bucketId  A unique identifier for the bucket you are updating.
	 * @param  array  $options  The visibility of the bucket. Public buckets don't
	 *                          require an authorization token to download objects, but still require a valid
	 *                          token for all other operations.
	 * @return ResponseInterface
	 *
	 * @throws Exception
	 */
	public function updateBucket($bucketId, $options): ResponseInterface
	{
		try {
			$body = json_encode([
				'id' => $bucketId,
				'name' => $bucketId,
				'public' => $options['public'] ? 'true' : 'false',
			]);
			$url = $this->url.'/bucket/'.$bucketId;
			$headers = array_merge($this->headers, ['Content-Type' => 'application/json']);
			$data = $this->__request('PUT', $url, $headers, $body);

			return $data;
		} catch (\Exception $e) {
			throw $e;
		}
	}

	/**
	 * Deletes an existing bucket. A bucket can't be deleted with existing objects inside it.
	 * You must first `empty()` the bucket.
	 *
	 * @param  string  $bucketId  The unique identifier of the bucket you would like to delete.
	 * @return ResponseInterface
	 *
	 * @throws Exception
	 */
	public function deleteBucket($bucketId): ResponseInterface
	{
		try {
			$url = $this->url.'/bucket/'.$bucketId;
			$headers = $this->__getHeaders();
			$data = $this->__request('DELETE', $url, $headers);

			return $data;
		} catch (\Exception $e) {
			throw $e;
		}
	}

	/**
	 * Removes all objects inside a single bucket.
	 *
	 * @param  string  $bucketId  The unique identifier of the bucket you would like to empty.
	 * @return ResponseInterface
	 *
	 * @throws Exception
	 */
	public function emptyBucket($bucketId): ResponseInterface
	{
		try {
			$url = $this->url.'/bucket/'.$bucketId.'/empty';
			$headers = $this->__getHeaders();
			$data = $this->__request('POST', $url, $headers);

			return $data;
		} catch (\Exception $e) {
			throw $e;
		}
	}
}
