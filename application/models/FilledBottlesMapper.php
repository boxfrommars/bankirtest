<?php

class Application_Model_FilledBottlesMapper
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
            $this->setDbTable('Application_Model_DbTable_FilledBottles');
        }
        return $this->_dbTable;
    }

    private function createFilledBottle($row){
        $bottle = new Application_Model_FilledBottles();
        $bottle->setId($row->id)
                ->setName($row->name)
                ->setBottle($row)
                ->setBeverage($row);
        return $bottle;
    }

    public function find($id)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $bottle = $this->createFilledBottle($row);
        return $bottle;
    }
 
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAllFull();
        $entries   = array();
        foreach ($resultSet as $row) {
            $bottle = $this->createFilledBottle($row);
            $entries[] = $bottle;
        }
    
        return $entries;
    }
}

