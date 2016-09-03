<?php

namespace ActivatorAdmin\Lib;

/**
 * This interface is to be implemented by all models.
 */
interface iModel
{
    public function load($id);
    public function save();
    public function delete();
    public function toArray();
}
