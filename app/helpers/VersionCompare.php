<?php

namespace Book\Shop\Helpers;

class VersionCompare
{
    public static function compare(string $version): string
    {
        if (version_compare($version, TIMEZONE_VERSION_COMPARE, ">=")) {
            return 'UTC';
        }
        return 'Europe/Berlin';
    }
}
