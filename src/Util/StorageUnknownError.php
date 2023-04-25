<?php

namespace Supabase\Storage\Util;

class StorageUnknownError extends StorageError
{
	public function __construct($message, $originalError)
	{
		parent::__construct($message);
		$this->name = 'StorageUnknownError';
		$this->originalError = $originalError;
	}
}
