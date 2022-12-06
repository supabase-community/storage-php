<?php

namespace Supabase\Storage;

class StorageClient extends StorageBucket
{
    public function __construct($url, $headers)
    {
        parent::__construct($url, $headers);
    }

    public function from($bucketId)
    {
        return new StorageBucket($this->url, $this->headers, $bucketId);
    }
}
