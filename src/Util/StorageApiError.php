<?php

namespace Supabase\Util;

class StorageApiError extends StorageError
{
    protected int $status;

    public function __construct($message, $status)
    {
        parent::__construct($message);
        $this->status = $status;
        $this->name = 'StorageApiError';
    }
}
