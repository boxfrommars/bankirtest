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
        
        $bottle = new Application_Model_Bottles();
        $bottle->setId($row->bottle_id)
                ->setName($row->bottle_name)
                ->setDescription($row->bottle_description)
                ->setImg($row->bottle_img_src);
        
        $beverage = new Application_Model_Beverages();
        $beverage->setId($row->beverage_id)
                ->setName($row->beverage_name)
                ->setDescription($row->beverage_description);
        
        $filledBottle = new Application_Model_FilledBottles();        
        $filledBottle->setId($row->id)
                ->setName($row->name)
                ->setBottle($bottle)
                ->setBeverage($beverage);
                
        return $filledBottle;
    }

    public function find($id)
    {
        $result = $this->getDbTable()->findFull($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $bottle = $this->createFilledBottle($row);
        return $bottle;
    }
    
    public function save(Application_Model_FilledBottles $filledBottle)
    {
        $data = array(
            'name'   => $filledBottle->name,
            'beverage_id'   => $filledBottle->beverage->id,
            'bottle_id' => $filledBottle->bottle->id
        );
        if (null === ($id = $filledBottle->getId())) {
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
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

