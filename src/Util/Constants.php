<?php

namespace Supabase\Util;

class Constants
{
    public static $VERSION = '0.0.1';
    public static function getDefaultHeaders()
    {
        return [
            'X-Client-Info' => 'storage-php/' . self::$VERSION,
        ];
    }
}
