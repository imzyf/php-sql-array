<?php

declare(strict_types=1);

namespace QueryArray;

trait QueryTrait
{
    /**
     * @var string|array|ExpressionInterface query condition. This refers to the WHERE clause in a SQL statement.
     *                                       For example, `['age' => 31, 'team' => 1]`.
     *
     * @see where() for valid syntax on specifying this value.
     */
    public $where;
}
