<?php

namespace ActivatorAdmin\Lib;

class Item
{

    protected $id, $name, $isActive, $image;

    public function save()
    {
        // TODO
    }

    public function delete()
    {
        // TODO
    }

    public function setId($id)
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
