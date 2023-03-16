<?php

namespace Supabase\Storage;

class StorageClient extends StorageBucket
{
	public function __construct($api_key, $reference_id, $domain, $scheme, $path)
	{
		parent::__construct($api_key, $reference_id, $domain, $scheme, $path);
	}

	public function from($bucketId)
	{
		return new StorageBucket($this->api_key, $this->reference_id, $this->$domain, $this->$scheme, $this->$path, $bucketId);
	}
}
