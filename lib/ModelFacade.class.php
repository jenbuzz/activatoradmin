<?php

namespace ActivatorAdmin\Lib;

require_once 'ConfigHelper.class.php';
require_once 'DB.class.php';
require_once 'Item.class.php';

class ModelFacade
{
    private $model = false;

    public function __construct($modelname)
    {
        switch ($modelname) {
            case 'Item':
                $this->model = new Item();
        }
    }

    public function loadAll()
    {
        if ($this->model) {
            $objConfigHelper = new ConfigHelper();
            $dbConfig = $objConfigHelper->get('db');

            $objDB = DB::getInstance($dbConfig);

            $arrItemObjects = array();
            $arrItems = $objDB->select($dbConfig['table']);
            foreach ($arrItems as $item) {
                $objItem = new Item();
                $objItem->load($item['id']);
                $arrItemObjects[] = $objItem;
            }

            return $arrItemObjects;
        } else {
            return false;
        }
    }

    public function load($id)
    {
        if ($this->model) {
            $this->model->load($id);
            return $this->model;
        } else {
            return false;
        }
    }

    public function save()
    {
        if ($this->model) {
            $this->model->save();

            return true;
        } else {
            return false;
        }
    }

    public function delete()
    {
        if ($this->model) {
            $this->model->delete();

            return true;
        } else {
            return false;
        }
    }
}
