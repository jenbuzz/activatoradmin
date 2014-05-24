<?php

namespace ActivatorAdmin\Lib;

require_once(__DIR__ . '/DB.class.php');
require_once(__DIR__ . '/ConfigHelper.class.php');

use \ActivatorAdmin\Lib\DB;
use \ActivatorAdmin\Lib\ConfigHelper;

class Item
{
    private $objDB, $table;
    protected $id, $name, $isActive, $image;

    public function __construct()
    {
        $objConfigHelper = new ConfigHelper();
        $dbConfig = $objConfigHelper->get('db');

        $this->objDB = DB::getInstance($dbConfig);
        $this->table = $dbConfig['table'];
    }

    public function load($id)
    {
        $result = $this->objDB->select($this->table, '*', 'id', $id);
        if ($result) {
            $this->setId($result['id']);
            $this->setName($result['name']);
            $this->setIsActive($result['isactive']);
            $this->setImage($result['image']);
        }
    }

    public function save()
    {
        if ($this->id) {
            $this->objDB->update($this->table, array('isactive'=>$this->getIsActive()), 'id', $this->getId());
        } else {
            $this->objDB->insert($this->table, array(
                'name'=>$this->getName(),
                'isactive'=>$this->getIsActive(),
                'image'=>$this->getImage()
            ));
        }
    }

    public function delete()
    {
        $this->objDB->delete($this->table, 'id', $this->getId());
    }

    private function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

}

?>
