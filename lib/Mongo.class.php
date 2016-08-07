<?php

namespace ActivatorAdmin\Lib;

/**
 * Mongo is used for setting up a connection to a MongoDB.
 * Mongo is a singleton.
 *
 */
class Mongo
{
    private static $instance;
    private $mongoCollection;

    /**
     * Connect to a MongoDB with the credentials from the $config['mongo'] array.
     *
     * @param array $config is the mongo entry in the configuration array that is setup in class ConfigHelper.
     */
    private function __construct(array $config)
    {
        $username = $config['user'];
        $password = $config['pass'];

        $strAuthentication = 'mongodb://';
        if ($username !== '' && $password !== '') {
            $strAuthentication.= $username . ':' . $password . '@';
        }
        $strAuthentication.= $config['host'];

        $client = new \MongoClient($strAuthentication);
        $db = $client->{$config['name']};
        $this->mongoCollection = $db->{$config['collection']};
    }

    /**
     * getInstance returns an instance of Mongo (Singleton Pattern).
     *
     * @param array $config is the mongo entry in the configuration array that is setup in class ConfigHelper.
     *
     * @return object Mongo
     */
    public static function getInstance(array $config)
    {
        if (static::$instance === null) {
            static::$instance = new static($config);
        }

        return static::$instance;
    }

    public function select($columns='*', $whereColumn=false, $whereValue=false, $orderBy=false, $limit=false)
    {
        $results = array();

        $query = array();
        if ($whereColumn && $whereValue) {
            if ($whereColumn === 'id') {
                $whereColumn = '_id';
                $whereValue = new \MongoId($whereValue);
            }

            $query[$whereColumn] = $whereValue;
        }

        $cursor = $this->mongoCollection->find($query);

        if ($limit) {
            $cursor->limit($limit);
        }

        foreach ($cursor AS $document) {
            $document['id'] = (string) $document['_id'];
            $results[] = $document;
        }

        if (count($results)===1) {
            $results = $results[0];
        }

        return $results;
    }

    public function insert($document)
    {
        if (is_array($document) && !empty($document)) {
            $this->mongoCollection->insert($document);
        }
    }

    public function delete($whereColumn, $whereValue)
    {
        if ($whereColumn === 'id') {
            $whereColumn = '_id';
            $whereValue = new \MongoId($whereValue);
        }

        $this->mongoCollection->remove(array(
            $whereColumn => $whereValue,
        ));
    }
}
