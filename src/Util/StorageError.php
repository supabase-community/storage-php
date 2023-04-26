<?php

namespace Supabase\Storage\Util;

class StorageError extends \Exception
{
	protected bool $isStorageError = true;
	public string $name = 'StorageError';

	public function __construct($message)
	{
		parent::__construct($message);
		$this->name = 'StorageError';
	}

	public static function isStorageError($e)
	{
		return $e != null && isset($e->isStorageError);
	}
}
