<?php

declare(strict_types=1);

namespace Test\LizhiDev\QueryArray;

use LizhiDev\QueryArray\ActiveArray;
use PHPUnit\Framework\TestCase;

class QueryTest extends TestCase
{
    public function testSelect()
    {
        $raw = [
            ['id' => 1, 'name' => 'Liming1', 'age' => 11],
            ['id' => 2, 'name' => 'Liming2', 'age' => 12],
            ['id' => 3, 'name' => 'Liming3', 'age' => 13],
            ['id' => 10, 'name' => 'Liming10', 'age' => 20],
            ['id' => 11, 'name' => 'Liming11', 'age' => 21],
            ['id' => 12, 'name' => 'Liming12', 'age' => 22],
        ];
        $arr = ActiveArray::find($raw);
        $ret = $arr->select('id,name')
            ->andWhere([
                'id' => 2,
            ])
            ->indexBy('name')
            ->all();

        dd($ret);
    }
}
