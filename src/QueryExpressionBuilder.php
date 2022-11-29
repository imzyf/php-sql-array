<?php

declare(strict_types=1);

namespace LizhiDev\QueryArray;

class QueryExpressionBuilder implements ExpressionInterface
{
    use ExpressionBuilderTrait;

    /**
     * Method builds the raw SQL from the $expression that will not be additionally
     * escaped or quoted.
     *
     * @param ExpressionInterface|Query $expression the expression to be built
     * @param array                     $params     the binding parameters
     *
     * @return string the raw SQL that will not be additionally escaped or quoted
     */
    public function build(ExpressionInterface $expression, array &$params = []): string
    {
        [$sql, $params] = $this->queryBuilder->build($expression, $params);

        return "($sql)";
    }
}
