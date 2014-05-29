<?php

namespace ActivatorAdmin\Lib;

require_once(__DIR__ . '/DB.class.php');
require_once(__DIR__ . '/ConfigHelper.class.php');
require_once(__DIR__ . '/Model.interface.php');

class Item implements iModel
{
    private $objDB, $table;
    protected $tblName, $tblIsActive, $tblImage;
    protected $id, $name, $isActive, $image;

    public function __construct()
    {
        $objConfigHelper = new ConfigHelper();
        $dbConfig = $objConfigHelper->get('db');

        $this->objDB = DB::getInstance($dbConfig);
        $this->table = $dbConfig['table'];

        $dbMapping = $objConfigHelper->get('db_mapping');
        $this->tblName = $dbMapping['name'];
        $this->tblIsActive = $dbMapping['isactive'];
        $this->tblImage = $dbMapping['image'];
    }

    public function load($id)
    {
        $result = $this->objDB->select($this->table, '*', 'id', $id);
        if ($result) {
            $this->setId($result['id']);
            $this->setName($result[$this->tblName]);
            $this->setIsActive($result[$this->tblIsActive]);
            $this->setImage($result[$this->tblImage]);
        }
    }

    public function save()
    {
        if ($this->getId()) {
            $this->objDB->update($this->table, array($this->tblName=>$this->getName(), $this->tblIsActive=>$this->getIsActive(), $this->tblImage=>$this->getImage()), 'id', $this->getId());
        } else {
            $this->objDB->insert($this->table, array(
                $this->tblName=>$this->getName(),
                $this->tblIsActive=>$this->getIsActive(),
                $this->tblImage=>$this->getImage()
            ));
        }
    }

    public function delete()
    {
        $this->objDB->delete($this->table, 'id', $this->getId());
    }

    public function toArray()
    {
        $arr = array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'isactive' => $this->getIsActive(),
            'image' => $this->getImage(),
        );

        return $arr;
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

    public function getImage()
    {
        return $this->image;
    }

}
