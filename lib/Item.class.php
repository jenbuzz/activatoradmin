<?php
/**
 * Item is the model class for an item.
 * It implements the iModel interface.
 *
 */
namespace ActivatorAdmin\Lib;

class Item implements iModel
{
    /**
     * @var $objDB DB 
     */
    private $objDB;

    private $table;
    protected $tblName, $tblIsActive, $tblImage;
    protected $id, $name, $isActive, $image;

    /**
     * Setup the database connection and the table mapping.
     *
     * @param array $dbConfig to use custom  DB config settings.
     */
    public function __construct($dbConfig = false)
    {
        $objConfigHelper = new ConfigHelper();

        if (!$dbConfig || !is_array($dbConfig)) {
            $dbConfig = $objConfigHelper->get('db');
        }

        $this->objDB = DB::getInstance($dbConfig);
        $this->table = $dbConfig['table'];

        $dbMapping = $objConfigHelper->get('db_mapping');
        $this->tblName = $dbMapping['name'];
        $this->tblIsActive = $dbMapping['isactive'];
        $this->tblImage = $dbMapping['image'];
    }

    /**
     * Load a single item.
     *
     * @param int $id is the id of the item to load.
     */
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

    /**
     * Save the item to the database.
     * Perform an update if the item id is set, otherwise insert.
     */
    public function save()
    {
        if ($this->getId()) {
            $this->objDB->update(
                $this->table,
                array(
                    $this->tblName => $this->getName(),
                    $this->tblIsActive => $this->getIsActive(),
                    $this->tblImage => $this->getImage(),
                ),
                'id',
                $this->getId()
            );
        } else {
            $this->objDB->insert($this->table, array(
                $this->tblName => $this->getName(),
                $this->tblIsActive => $this->getIsActive(),
                $this->tblImage => $this->getImage(),
            ));
        }
    }

    /**
     * Delete the item in the database.
     */
    public function delete()
    {
        $this->objDB->delete($this->table, 'id', $this->getId());
    }

    /**
     * Return an array of the item.
     */
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

    /**
     * Set the id of the item. Private function!
     *
     * @param int $id
     */
    private function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get the id of the item.
     *
     * @return int id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the name of the item.
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get the name of the item.
     *
     * @return string name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the "is active" status of the item.
     *
     * @param int $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * Get the "is active" status of the item.
     *
     * @return int isActive
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set the image of the item.
     *
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Get the image of the item.
     *
     * @return string image
     */
    public function getImage()
    {
        return $this->image;
    }

}
