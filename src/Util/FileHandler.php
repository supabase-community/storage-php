<?php

namespace Supabase\Util;


class FileHandler 
{
	public static function getFileContents($file): String 
	{
		return file_get_contents($file);
	}
}
