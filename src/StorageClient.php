<?php

namespace Supabase\Storage;

class StorageClient extends StorageBucket
{
	private mixed $domain;
	private mixed $scheme;
	private mixed $path;
	private mixed $api_key;
	private mixed $reference_id;

	/**
	 * StorageClient constructor.
	 *
	 * @param  string  $api_key  The anon or service role key
	 * @param  string  $reference_id  Reference ID
	 * @param  string  $domain  The domain pointing to api
	 * @param  string  $scheme  The api sheme
	 * @param  string  $path  The path to api
	 *
	 * @throws Exception
	 */
	public function __construct($api_key, $reference_id, $domain = 'supabase.co', $scheme = 'https', $path = '/storage/v1')
	{
		parent::__construct($api_key, $reference_id, '', $domain, $scheme, $path);

		$this->domain = $domain;
		$this->scheme = $scheme;
		$this->path = $path;
		$this->api_key = $api_key;
		$this->reference_id = $reference_id;
	}

	public function from($bucketId)
	{
		return new StorageBucket($this->api_key, $this->reference_id, $bucketId, $this->domain, $this->scheme, $this->path);
	}
}
