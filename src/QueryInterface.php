<?php

declare(strict_types=1);

namespace Yifans\QueryArray;

interface QueryInterface
{
    public function all(): array;

    public function one();

    public function count(): int;

    public function exists();

    public function where($condition);

    public function andWhere($condition);

    public function orWhere($condition);

    public function orderBy($columns);

    public function addOrderBy($columns);

    public function limit($limit);
}
