<?php

namespace App\Helpers;

/**
 * Class StringHelper
 *
 * @package App\Helpers
 */
class StringHelper
{
    /**
     * @param string|null $string
     * @param int         $option
     *
     * @return string|null
     */
    static function sanitize(string $string = null, int $option = FILTER_SANITIZE_STRING)
    {
        return filter_var($string, $option);
    }
}
