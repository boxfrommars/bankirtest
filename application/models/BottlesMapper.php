<?php

class Application_Model_BottlesMapper
{
    // интерфейс к таблице бд
    protected $_dbTable;
 
    /**
     * устанавливает $_dbTable
     *
     * @param string $dbTable
     * @return Application_Model_BottlesMapper $this
     */
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
 
    /**
     * @return Zend_Db_Table_Abstract $_dbTable
     */
    public function getDbTable()
    {
        // лениво устанавливаем $_dbTable
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Bottles');
        }
        return $this->_dbTable;
    }

    /**
     * создает объект бутылки
     *
     * @param Object $row
     * @return Application_Model_Bottles $bottle
     */
    private function createBottle($row){
        $bottle = new Application_Model_Bottles();
        $bottle->setId($row->id)
                ->setName($row->name)
                ->setDescription($row->description)
                ->setImg($row->img_src);
        return $bottle;
    }

    /**
     * находит бутылку
     *
     * @param integer $id
     * @return Application_Model_Bottles $bottle
     */
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
 
    /**
     * находит все бутылки
     *
     * @return array of Application_Model_Bottles $bottles
     */
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

