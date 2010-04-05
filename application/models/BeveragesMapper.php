<?php

class Application_Model_BeveragesMapper
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
            $this->setDbTable('Application_Model_DbTable_Beverages');
        }
        return $this->_dbTable;
    }
 
    private function createBeverage($row){
        $beverage = new Application_Model_Beverages();
        $beverage->setId($row->id)
                 ->setName($row->name)
                 ->setDescription($row->description);
        return $beverage;
    }
    /**
     * Create Search Docs for search model.
     * 
     */
    private function createSearchDoc($row){
        $doc = new Application_Model_SearchDoc();
        $doc->setId($row-id)
            ->setTitle($row->name)
            ->setContent($row->description)
            ->setType('beverages');
        return $doc;
    }
    
    public function save(Application_Model_Beverages $beverage)
    {
        $data = array(
            'name'   => $beverage->getName(),
            'description' => $beverage->getDescription()
        );
        if (null === ($id = $beverage->getId())) {
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
 
    public function find($id)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $beverage = $this->createBeverage($row);
        return $beverage;
    }

    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entries[] = $this->createBeverage($row);
        }
        return $entries;
    }

    public function fetchAllSearchDocs()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entries[] = $this->createSearchDoc($row);
        }
        return $entries;
    }
}

