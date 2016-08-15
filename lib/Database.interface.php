<?php

namespace ActivatorAdmin\Lib;

/**
 * This interface is to be implemented by all database classes.
 *
 */
interface iDatabase
{
    public function select($columns='*', $whereColumn=false, $whereValue=false, $orderBy=false, $limit=false);
    public function insert($data);
    public function update($data, $whereColumn=false, $whereValue=false);
    public function delete($whereColumn, $whereValue);
}
