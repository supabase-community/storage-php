<?php

namespace Supabase\Storage\Util;

class StorageApiError extends StorageError
{
	protected int $status;
	public string $name = 'StorageError';

	public function __construct($message, $status)
	{
		parent::__construct($message);
		$this->status = $status;
		$this->name = 'StorageApiError';
	}
}
