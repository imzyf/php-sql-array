<?php

declare(strict_types=1);

namespace LizhiDev\QueryArray;

use Illuminate\Support\Arr;

class Query implements QueryInterface, ExpressionInterface
{
    use QueryTrait;

    /**
     * @var array the columns being selected. For example, `['id', 'name']`.
     *            This is used to construct the SELECT clause in a SQL statement. If not set, it means selecting all columns.
     *
     * @see select()
     */
    public $select;
    /**
     * @var string additional option that should be appended to the 'SELECT' keyword. For example,
     *             in MySQL, the option 'SQL_CALC_FOUND_ROWS' can be used.
     */
    public $selectOption;
    /**
     * @var bool whether to select distinct rows of data only. If this is set true,
     *           the SELECT clause would be changed to SELECT DISTINCT.
     */
    public $distinct;
    /**
     * @var array the table(s) to be selected from. For example, `['user', 'post']`.
     *            This is used to construct the FROM clause in a SQL statement.
     *
     * @see from()
     */
    public $from;
    /**
     * @var array how to group the query results. For example, `['company', 'department']`.
     *            This is used to construct the GROUP BY clause in a SQL statement.
     */
    public $groupBy;
    /**
     * @var array how to join with other tables. Each array element represents the specification
     *            of one join which has the following structure:
     *
     * ```php
     * [$joinType, $tableName, $joinCondition]
     * ```
     *
     * For example,
     *
     * ```php
     * [
     *     ['INNER JOIN', 'user', 'user.id = author_id'],
     *     ['LEFT JOIN', 'team', 'team.id = team_id'],
     * ]
     * ```
     */
    public $join;
    /**
     * @var string|array|ExpressionInterface the condition to be applied in the GROUP BY clause.
     *                                       It can be either a string or an array. Please refer to [[where()]] on how to specify the condition.
     */
    public $having;
    /**
     * @var array this is used to construct the UNION clause(s) in a SQL statement.
     *            Each array element is an array of the following structure:
     *
     * - `query`: either a string or a [[Query]] object representing a query
     * - `all`: boolean, whether it should be `UNION ALL` or `UNION`
     */
    public $union;
    /**
     * @var array this is used to construct the WITH section in a SQL query.
     *            Each array element is an array of the following structure:
     *
     * - `query`: either a string or a [[Query]] object representing a query
     * - `alias`: string, alias of query for further usage
     * - `recursive`: boolean, whether it should be `WITH RECURSIVE` or `WITH`
     *
     * @see withQuery()
     * @since 2.0.35
     */
    public $withQueries;
    /**
     * @var array list of query parameter values indexed by parameter placeholders.
     *            For example, `[':name' => 'Dan', ':age' => 31]`.
     */
    public $params = [];
    /**
     * @var int|true the default number of seconds that query results can remain valid in cache.
     *               Use 0 to indicate that the cached data will never expire.
     *               Use a negative number to indicate that query cache should not be used.
     *               Use boolean `true` to indicate that [[Connection::queryCacheDuration]] should be used.
     *
     * @see cache()
     * @since 2.0.14
     */
    public $queryCacheDuration;
    /**
     * @var Caching\Dependency the dependency to be associated with the cached query result for this query
     *
     * @see cache()
     * @since 2.0.14
     */
    public $queryCacheDependency;

    public function all(): array
    {
        if ($this->emulateExecution) {
            return [];
        }

        $rows = $this->createCommand()->queryAll();

        return $this->populate($rows);
    }

    public function one()
    {
        // TODO: Implement one() method.
    }

    public function count(): int
    {
        // TODO: Implement count() method.
    }

    public function exists(): bool
    {
        // TODO: Implement exists() method.
    }

    public function createCommand()
    {
        return $command;
    }

    /**
     * Converts the raw query results into the format as specified by this query.
     * This method is internally used to convert the data fetched from database
     * into the format as required by this query.
     *
     * @param array $rows the raw query result from database
     *
     * @return array the converted query result
     */
    public function populate(array $rows): array
    {
        if (null === $this->indexBy) {
            return $rows;
        }
        $result = [];
        foreach ($rows as $row) {
            $result[Arr::get($row, $this->indexBy)] = $row;
        }

        return $result;
    }
}
