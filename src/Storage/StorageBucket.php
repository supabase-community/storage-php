<?php

namespace Supabase\Storage;

use Supabase\Util\Constants;
use Supabase\Util\Request;

class StorageBucket
{
	protected string $url;
	protected array $headers = [];

	public function __construct($url, $headers)
	{
		$this->url = $url;
		$this->headers = array_merge(Constants::getDefaultHeaders(), $headers);
	}

	/**
	 * Creates a new Storage bucket.
	 *
	 * @param  string  $bucketId  The bucketId to create.
	 */
	public function createBucket($bucketId, $options = ['public' => false])
	{
		try {
			$url = $this->url.'/bucket';
			$body = json_encode([
				'id' => $bucketId,
				'name' => $bucketId,
				'public' => $options['public'],
			]);
			$headers = array_merge($this->headers, ['Content-Type' => 'application/json']);
			$data = Request::request('POST', $url, $headers, $body);

			return $data;
		} catch (\Exception $e) {
			return $e;
		}
	}

	/**
	 * Retrieves the details of an existing Storage bucket by bucketId.
	 *
	 * @param  string  $bucketId  The bucketId to get.
	 * @return array
	 */
	public function getBucket($bucketId)
	{
		try {
			$url = $this->url.'/bucket/'.$bucketId;
			$data = Request::request('GET', $url, $this->headers);

			return $data;
		} catch (\Exception $e) {
			return $e;
		}
	}

	/**
	 * Retrieves the details of all Storage buckets within an existing project.
	 *
	 * @return array
	 */
	public function listBuckets()
	{
		$url = $this->url.'/bucket';

		try {
			$data = Request::request('GET', $url, $this->headers);

			return $data;
		} catch (\Exception $e) {
			return $e;
		}
	}

	/**
	 * Updates a Storage bucket by bucketId.
	 *
	 * @param  string  $bucketId  The bucketId to update.
	 * @param  array  $options  The options for the update.
	 */
	public function updateBucket($bucketId, $options)
	{
		try {
			$body = json_encode([
				'id' => $bucketId,
				'name' => $bucketId,
				'public' => $options['public'] ? 'true' : 'false',
			]);
			$url = $this->url.'/bucket/'.$bucketId;
			$headers = array_merge($this->headers, ['Content-Type' => 'application/json']);
			$data = Request::request('PUT', $url, $headers, $body);

			return $data;
		} catch (\Exception $e) {
			return $e;
		}
	}

	/**
	 * Deletes an existing bucket. A bucket can't be deleted with existing objects inside it. You must first empty() the bucket.
	 *
	 * @param  string  $bucketId  The bucketId to delete.
	 */
	public function deleteBucket($bucketId)
	{
		try {
			$url = $this->url.'/bucket/'.$bucketId;
			$data = Request::request('DELETE', $url, $this->headers);

			return $data;
		} catch (\Exception $e) {
			return $e;
		}
	}

	/**
	 * Removes all objects inside a single bucket.
	 *
	 * @param  string  $bucketId  The bucketId to empty.
	 */
	public function emptyBucket($bucketId)
	{
		try {
			$url = $this->url.'/bucket/'.$bucketId.'/empty';
			$data = Request::request('POST', $url, $this->headers);

			return $data;
		} catch (\Exception $e) {
			return $e;
		}
	}
}
