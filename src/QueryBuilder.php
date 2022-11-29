<?php

declare(strict_types=1);

namespace LizhiDev\QueryArray;

use LizhiDev\Yii\Base\BaseObject;

class QueryBuilder extends BaseObject
{
    /**
     * The prefix for automatically generated query binding parameters.
     */
    public const PARAM_PREFIX = ':qp';

    /**
     * @var string the separator between different fragments of a SQL statement.
     *             Defaults to an empty space. This is mainly used by [[build()]] when generating a SQL statement.
     */
    public $separator = ' ';

    /**
     * @var array the abstract column types mapped to physical column types.
     *            This is mainly used to support creating/modifying tables using DB-independent data type specifications.
     *            Child classes should override this property to declare supported type mappings.
     */
    public $typeMap = [];

    /**
     * @var array map of condition aliases to condition classes. For example:
     *
     * ```php
     * return [
     *     'LIKE' => yii\db\condition\LikeCondition::class,
     * ];
     * ```
     *
     * This property is used by [[createConditionFromArray]] method.
     * See default condition classes list in [[defaultConditionClasses()]] method.
     *
     * In case you want to add custom conditions support, use the [[setConditionClasses()]] method.
     *
     * @see setConditonClasses()
     * @see defaultConditionClasses()
     * @since 2.0.14
     */
    protected $conditionClasses = [];

    /**
     * @var string[] maps expression class to expression builder class.
     *               For example:
     *
     * ```php
     * [
     *    yii\db\Expression::class => yii\db\ExpressionBuilder::class
     * ]
     * ```
     * This property is mainly used by [[buildExpression()]] to build SQL expressions form expression objects.
     * See default values in [[defaultExpressionBuilders()]] method.
     *
     * @see setExpressionBuilders()
     * @see defaultExpressionBuilders()
     * @since 2.0.14
     */
    protected $expressionBuilders = [];

    public function init(): void
    {
        parent::init();

        $this->expressionBuilders = array_merge($this->defaultExpressionBuilders(), $this->expressionBuilders);
        $this->conditionClasses = array_merge($this->defaultConditionClasses(), $this->conditionClasses);
    }

    protected function defaultConditionClasses(): array
    {
        return [
            'NOT' => 'yii\db\conditions\NotCondition',
            'AND' => 'yii\db\conditions\AndCondition',
            'OR' => 'yii\db\conditions\OrCondition',
            'BETWEEN' => 'yii\db\conditions\BetweenCondition',
            'NOT BETWEEN' => 'yii\db\conditions\BetweenCondition',
            'IN' => 'yii\db\conditions\InCondition',
            'NOT IN' => 'yii\db\conditions\InCondition',
            'LIKE' => 'yii\db\conditions\LikeCondition',
            'NOT LIKE' => 'yii\db\conditions\LikeCondition',
            'OR LIKE' => 'yii\db\conditions\LikeCondition',
            'OR NOT LIKE' => 'yii\db\conditions\LikeCondition',
            'EXISTS' => 'yii\db\conditions\ExistsCondition',
            'NOT EXISTS' => 'yii\db\conditions\ExistsCondition',
        ];
    }

    protected function defaultExpressionBuilders(): array
    {
        return [];
    }

    public function setExpressionBuilders(array $builders): void
    {
        $this->expressionBuilders = array_merge($this->expressionBuilders, $builders);
    }

    public function setConditionClasses(array $classes): void
    {
        $this->conditionClasses = array_merge($this->conditionClasses, $classes);
    }

    protected $raw = [];
    protected $selects = [];
    protected $wheres = [];

    /**
     * Generates a SELECT SQL statement from a [[Query]] object.
     *
     * @param Query $query  the [[Query]] object from which the SQL statement will be generated
     * @param array $params the parameters to be bound to the generated SQL statement. These parameters will
     *                      be included in the result with the additional parameters generated during the query building process.
     *
     * @return $this the generated SQL statement (the first array element) and the corresponding
     *               parameters to be bound to the SQL statement (the second array element). The parameters returned
     *               include those provided in `$params`.
     */
    public function build(Query $query, $params = [])
    {
//        $query = $query->prepare($this);
//        $params = empty($params) ? $query->params : array_merge($params, $query->params);

        $this->raw = $query->raw;
        $this->selects = $this->buildSelect($query->select, $params, $query->distinct, $query->selectOption);
        $this->wheres = $this->buildWhere($query->where, $params);

        $clauses = [
//            $this->buildWhere($query->where, $params),
//            $this->buildGroupBy($query->groupBy),
//            $this->buildHaving($query->having, $params),
        ];

        return $this;
    }

    public function queryAll(): array
    {
        return $this->queryInternal('fetchAll');
    }

    protected function queryInternal($method): array
    {
        $this->wheres;
        $filter = static function ($v, $k) {
        };

        return collect($this->raw)
            ->where($key)
            ->all();
    }

    public function buildSelect($columns, &$params, $distinct = false, $selectOption = null)
    {
        return $columns;
    }

    public function buildWhere($condition, &$params)
    {
        $where = $this->buildCondition($condition, $params);

        return $where;
    }

    public function buildCondition($condition, &$params)
    {
        if (is_array($condition)) {
            if (empty($condition)) {
                return '';
            }

            $condition = $this->createConditionFromArray($condition);
        }

        return (string) $condition;
    }

    public function createConditionFromArray($condition)
    {
        if (isset($condition[0])) { // operator format: operator, operand 1, operand 2, ...
            $operator = strtoupper(array_shift($condition));
            if (isset($this->conditionClasses[$operator])) {
                $className = $this->conditionClasses[$operator];
            } else {
                $className = 'yii\db\conditions\SimpleCondition';
            }
            /* @var ConditionInterface $className */
            return $className::fromArrayDefinition($operator, $condition);
        }

        // hash format: 'column1' => 'value1', 'column2' => 'value2', ...
        return new HashCondition($condition);
    }
}
