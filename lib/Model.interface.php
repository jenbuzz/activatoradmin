<?php
/**
 * This interface is to be implemented by all models.
 *
 */
namespace ActivatorAdmin\Lib;

interface iModel
{
    public function load($id);
    public function save();
    public function delete();
    public function toArray();
}
