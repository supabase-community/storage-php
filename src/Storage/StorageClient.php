<?php

namespace Supabase\Storage;

class StorageClient extends StorageBucket
{
	public function __construct()
	{
		parent::__construct();
	}

	public function from($bucketId)
	{
		return new StorageBucket($bucketId);
	}
}
