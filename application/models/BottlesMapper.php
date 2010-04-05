<?php

class Application_Model_BottlesMapper
{
    protected $_dbTable;
 
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
 
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Bottles');
        }
        return $this->_dbTable;
    }

    private function createBottle($row){
        $bottle = new Application_Model_Bottles();
        $bottle->setId($row->id)
                ->setName($row->name)
                ->setDescription($row->description)
                ->setImg($row->img_src);
        return $bottle;
    }

    public function find($id)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $bottle = $this->createBottle($row);
        return $bottle;
    }
 
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $bottle = $this->createBottle($row);
            $entries[] = $bottle;
        }
        return $entries;
    }

}

