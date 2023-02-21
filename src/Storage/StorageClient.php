<?php

namespace Supabase\Storage;

class StorageClient extends StorageBucket
{
	public function __construct($api_key, $reference_id)
	{
		parent::__construct($api_key, $reference_id);
	}

	public function from($bucketId)
	{
		return new StorageBucket($this->api_key, $this->reference_id, $bucketId);
	}
}
