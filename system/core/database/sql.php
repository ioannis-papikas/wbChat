<?php

/**
 * Creates SQL queries.
 * 
 * @author Marios
 * @version 0.4
 */
class SqlQueryCreator {

    /**
     * @var array The clauses of the query (e.g., select).
     */
    private $clauses;

    /**
     * @var string The query created.
     */
    private $query = '';

    /**
     * Creates a new SqlQueryCreator.
     */
    public function __construct() {
        $this->clauses = array(
            'from' => array(),
            'group_by' => array(),
            'having' => array(),
            'inner_join' => array(),
            'left_outer_join' => array(),
            'right_outer_join' => array(),
            'sort_by' => array(),
            'select' => array(),
            'where' => array()
        );
    }

    /**
     * Adds an AND clause to the statement.
     * @param string $condition The condition to be added as an AND clause.
     * @return SqlQueryCreator This SqlQueryCreator for method call chaining.
     * @throws InvalidArgumentException if the condition is empty (in the PHP
     * sense)
     */
    public function andCondition($condition) {
        if (empty($condition)) {
            throw new InvalidArgumentException(
                    'Cannot add empty AND clause.');
        }
        
        if (empty($this->clauses['where'])) {
            $this->clauses['where'] = array($condition);
        } else {
            $this->clauses['where'][] = 'AND ' . $condition;
        }
        
        return $this;
    }

    /**
     * Creates the query with the clauses defined, so far.
     * 
     * @return void
     */
    public function createQuery() {
        $queryArr = array();

        if (!empty($this->clauses['select'])) {
            $queryArr[] = 'SELECT ' . implode(', ', $this->clauses['select']);
        }
        if (!empty($this->clauses['from'])) {
            $queryArr[] = 'FROM ' . implode(', ', $this->clauses['from']);
            
            if (!empty($this->clauses['inner_join'])) {
                $queryArr[] = implode(' ', $this->clauses['inner_join']);
            }
        }
        if (!empty($this->clauses['where'])) {
            $queryArr[] = 'WHERE ' . implode(' ', $this->clauses['where']);
        }
        if (!empty($this->clauses['group_by'])) {
            $queryArr[] = 'GROUP BY ' . implode(', ', $this->clauses['group_by']);
        }
        
        $this->query = implode(' ', $queryArr) . ';';
    }

    /**
     * Adds a FROM clause to the statement.
     * @param string $tableName The name of the table to be added to the FROM clause.
     * @param string $alias The alias of the added table.
     * @return SqlQueryCreator This SqlQueryCreator for method call chaining.
     * @throws InvalidArgumentException if table name is empty (in the PHP sense)
     */
    public function from($tableName, $alias = '') {
        if (empty($tableName)) {
            throw new InvalidArgumentException('Cannot add unnamed table to FROM clause.');
        }

        $clause = '`' . $tableName . '`';
        $clause .=!empty($alias) ? ' AS ' . $alias : '';
        $this->clauses['from'][] = $clause;

        return $this;
    }

    /**
     * Returns the query created.
     * 
     * @return string The query created.
     */
    public function getQuery() {
        return $this->query;
    }

    /**
     * Adds a column to the GROUP BY clause.
     * 
     * @param string $columnName The name of the column used for grouping the
     * results.
     * @return SqlQueryCreator This SqlQueryCreator for method call chaining.
     * @throws InvalidArgumentException if the column name is empty (in the PHP
     * sense)
     */
    public function groupBy($columnName) {
        if (empty($columnName)) {
            throw new InvalidArgumentException(
                    'Cannot group by an unnamed column.');
        }

        $this->clauses['group_by'][] = '`' . $columnName . '`';

        return $this;
    }

    /**
     * Adds a column of a specific table to the GROUP BY clause.
     * 
     * @param string $tableName The name of the table the given column belongs to.
     * @param string $columnName The name of the column used for grouping the
     * results.
     * @return SqlQueryCreator This SqlQueryCreator for method call chaining.
     */
    public function groupByTableColumn($tableName, $columnName) {
        if (empty($tableName)) {
            throw new InvalidArgumentException(
                    'Cannot group by a column of an unnamed table.');
        }
        if (empty($columnName)) {
            throw new InvalidArgumentException(
                    'Cannot group by an unnamed column.');
        }

        $this->clauses['group_by'][] = '`' . $tableName . '`.`' . $columnName . '`';

        return $this;
    }

    /**
     * 
     * @param $condition
     */
    function having($condition) {
        
    }

    /**
     * Adds an INNER JOIN clause to the query.
     * @param string $tableName The name of the table to join to an already
     * specified one.
     * @param string $alias The alias used for the joining table.
     * @param string $condition The condition the join is based upon.
     * @return SqlQueryCreator This SqlQueryCreator for method call chaining.
     * @throws InvalidArgumentException if either the table name or the condition
     * is empty (in the PHP sense)
     * @throws RuntimeException if no call to the {@link #from()} method has
     * already occurred
     */
    public function innerJoin($tableName, $alias, $condition) {
        if (empty($tableName) ) {
            throw new InvalidArgumentException(
                    'Cannot join unnamed table.');
        }
        if (empty($condition)) {
            throw new InvalidArgumentException(
                    'Cannot perform join based upon no condition.');
        }
        if (empty($this->clauses['from'])) {
            throw new RuntimeException(
                    'Cannot perform join when no other table has been specified, so far.');
        }
        
        $clause = 'INNER JOIN `' . $tableName . '`';
        $clause .= !empty($alias) ? ' AS ' . $alias : '';
        $clause .= ' ON ' . $condition;
        $this->clauses['inner_join'][] = $clause;
        
        return $this;
    }

    /**
     * 
     * @param string $tableName
     * @param string $alias
     * @param string $condition
     */
    function leftJoin($tableName, $alias, $condition) {
        
    }

    /**
     * 
     * @param condition
     */
    function orCondition($condition) {
        
    }

    /**
     * 
     * @param string $tableName
     * @param string $alias
     * @param string $condition
     */
    function rightJoin($tableName, $alias, $condition) {
        
    }

    /**
     * Adds a "SELECT *" clause to the query.
     * @return SqlQueryCreator This SqlQueryCreator for method call chaining.
     */
    public function selectAll() {
        $this->clauses['select'] = array('*');

        return $this;
    }

    /**
     * Adds a SELECT clause for a function (e.g., MAX()).
     * @param string $functionCode The code of the function to be added to the clause.
     * @return SqlQueryCreator This SqlQueryCreator for method call chaining.
     */
    public function selectFunction($functionCode) {
        if (empty($functionCode)) {
            throw new InvalidArgumentException(
                    'No code given for the SELECT clause.');
        }

        $this->clauses['select'][] = $functionCode;

        return $this;
    }

    /**
     * Adds a specific table's column to the SELECT clause.
     *
     * @param string $tableName The name of the table whose column will be added.
     * @param string $columnName The name of the column to be added.
     * @param string $alias The alias used for the column (optional).
     * @return SqlQueryCreator This SqlQueryCreator for method call chaining.
     * @throws InvalidArgumentException if either the table or the column name
     * is empty (in the PHP sense)
     */
    public function selectTableColumn($tableName, $columnName, $alias = '') {
        if (empty($tableName)) {
            throw new InvalidArgumentException(
                    'Cannot add unnamed table to the SELECT clause.');
        }
        if (empty($columnName)) {
            throw new InvalidArgumentException(
                    'Cannot add unnamed column to the SELECT clause.');
        }

        $clause = '`' . $tableName . '`.`' . $columnName . '`';
        $clause .=!empty($alias) ? ' ' . $alias : '';

        $this->clauses['select'][] = $clause;

        return $this;
    }

    /**
     * Adds multiple columns of a specific table to the SELECT clause.
     * 
     * @param string $tableName The name of the table whose columns will be added
     * to the clause.
     * @param array $columnNames The columns to be added to the clause.
     * @param array $columnAliases The aliases of the columns to be added to the
     * clause.
     * @return SqlQueryCreator This SqlQueryCreator for method call chaining.
     * @throws InvalidArgumentException if either the arrays of column names and
     * aliases are of different length or a table or column name is empty (in the
     * PHP sense)
     * @see #selectTableColumn
     */
    public function selectTableColumns($tableName, $columnNames, $columnAliases) {
        if (count($columnNames) !== count($columnAliases)) {
            throw new InvalidArgumentException(
                    'Column names and aliases cannot be of different lengths '
                    . '(names = ' . count($columnNames)
                    . ', aliases = ' . count($columnAliases) . ')');
        }

        $i = 0;
        try {
            foreach ($columnNames as $columnName) {
                $this->selectTableColumn($tableName, $columnName, $columnAliases[$i]);
                $i++;
            }
        } catch (InvalidArgumentException $ex) {
            throw new InvalidArgumentException(
                    'Could not add table column to SELECT clause.', 0, $ex);
        }

        return $this;
    }

    /**
     * 
     * @param string $columnName
     */
    function sortBy($columnName) {
        
    }

    /**
     * Adds a condition to the WHERE clause.
     * 
     * @param string $condition The condition to be used for row filtering.
     * @return SqlQueryCreator This SqlQueryCreator for method call chaining.
     */
    public function where($condition) {
        if (empty($condition)) {
            throw new InvalidArgumentException(
                    'Cannot check against an empty condition.');
        }

        $this->clauses['where'] = array($condition);

        return $this;
    }

}

?>