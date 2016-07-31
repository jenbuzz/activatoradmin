<?php

namespace ActivatorAdmin\Lib;

/**
 * The ModelFacade works as a facade for communication with all models.
 *
 */
class ModelFacade
{
    /**
     * @var $model iModel
     */
    private $model = false;

    /**
     * Pass the name of the model as string in the constructor.
     *
     * @param object $model
     */
    public function __construct(iModel $model)
    {
        $this->model = $model;
    }

    /**
     * Load all records of a certain model type and return them as model objects.
     *
     * @return array arrItemObjects
     */
    public function loadAll()
    {
        if ($this->model) {
            $objDB = DB::getInstance();

            $arrItemObjects = array();
            $arrItems = $objDB->select();
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

    /**
     * Load a single model by id.
     *
     * @param int $id is the id of the record to load as a model.
     *
     * @return object model
     */
    public function load($id)
    {
        if ($this->model) {
            $this->model->load($id);
            return $this->model;
        } else {
            return false;
        }
    }

    /**
     * Search for records/models where name matches the searchterm.
     *
     * @param string $term is the search term to match against.
     *
     * @return array arrItemObjects
     */
    public function search($term)
    {
        if ($this->model) {
            $objConfigHelper = new ConfigHelper();
            $dbMapping = $objConfigHelper->get('db_mapping');

            $objDB = DB::getInstance();

            $arrItemObjects = array();
            $arrItems = $objDB->search($dbMapping['name'], $term);
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

    /**
     * Return a count of records with the specified active status.
     *
     * @param int $isActive to count to activated or deactivated items.
     *
     * @return array arrItemObjects
     */
    public function countActiveStatus($isActive = true)
    {
        if ($this->model) {
            $isActive = (int) $isActive;

            $objConfigHelper = new ConfigHelper();
            $dbMapping = $objConfigHelper->get('db_mapping');

            $objDB = DB::getInstance();

            $arrCount = $objDB->select('COUNT(*) as countActiveStatus', $dbMapping['isactive'], $isActive);
            if ($arrCount && isset($arrCount['countActiveStatus'])) {
                return $arrCount['countActiveStatus'];
            }

            return 0;
        } else {
            return false;
        }
    }

}
