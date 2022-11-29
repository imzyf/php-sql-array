<?php

declare(strict_types=1);

namespace LizhiDev\QueryArray;

interface QueryInterface
{
    public function all(): array;

    public function one();

    public function count(): int;

    public function exists(): bool;

    /**
     * @param string|callable $column
     *
     * @return $this
     */
    public function indexBy($column): QueryInterface;

    public function where($condition): QueryInterface;

    public function andWhere($condition);

    public function orWhere($condition);

    public function filterWhere(array $condition);

    public function andFilterWhere(array $condition);

    public function orFilterWhere(array $condition);

    public function orderBy($columns);

    public function addOrderBy($columns);

    public function limit($limit);

    public function offset($offset);

    public function emulateExecution($value = true);
}
