<?php

declare(strict_types=1);

namespace LizhiDev\QueryArray;

class ActiveArray
{
    public static function find(array $raw): Query
    {
        $config = [
            'raw' => $raw,
        ];

        return new Query($config);
    }
}
