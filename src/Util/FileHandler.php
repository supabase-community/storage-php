<?php

namespace Supabase\Storage\Util;

class FileHandler
{
	public static function getFileContents($file): string
	{
		return file_get_contents($file);
	}
}
