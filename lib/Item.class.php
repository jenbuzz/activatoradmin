<?php

require_once(__DIR__ . '/DB.class.php');
require_once(__DIR__ . '/ConfigHelper.class.php');

namespace ActivatorAdmin\Lib;

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
