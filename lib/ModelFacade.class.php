<?php
/**
 * The ModelFacade works as a facade for communication with all models.
 *
 */
namespace ActivatorAdmin\Lib;

require_once __DIR__ . '/ConfigHelper.class.php';
require_once __DIR__ . '/DB.class.php';

class ModelFacade
{
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
     * Save a manipulated model to the database.
     *
     * @return boolean
     */
    public function save()
    {
        if ($this->model) {
            $this->model->save();

            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete a model from the database.
     *
     * @return boolean
     */
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
