<?php

namespace ActivatorAdmin\Lib;

/**
 * This interface is to be implemented by all database classes.
 */
interface iDatabase
{
    public function select(string $columns = '*', string $whereColumn = '', string $whereValue = '', string $orderBy = '', int $limit = 0);
    public function insert(array $data);
    public function update(array $data, string $whereColumn = '', string $whereValue = '');
    public function delete(string $whereColumn, string $whereValue);
}
