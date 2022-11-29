<?php

declare(strict_types=1);

namespace LizhiDev\QueryArray;

/**
 * some util.
 */
class Util
{
    /**
     * get array max depth.
     *
     * @return int array max depth
     */
    public static function depth($array)
    {
        if (!is_array($array)) {
            throw new \RuntimeException('No Array found', 2);
        }
        $max = 1;
        foreach ($array as $value) {
            if (is_array($value)) {
                $depth = static::depth($value) + 1;
                if ($depth > $max) {
                    $max = $depth;
                }
            }
        }

        return $max;
    }

    /**
     * get array max depth.
     *
     * @return bool
     */
    public static function isMultiple($data)
    {
        if (static::depth($data) > 2) {
            throw new \RuntimeException('Invalid 2D Array', 1);
        }
        $data = array_filter($data, 'is_array');

        return count($data) > 0;
    }
}
