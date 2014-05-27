<?php

namespace ActivatorAdmin\Lib;

interface iModel
{
    public function load($id);
    public function save();
    public function delete();
}
