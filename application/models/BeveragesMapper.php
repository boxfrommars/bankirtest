<?php

class Application_Model_BeveragesMapper
{
    // интерфейс к таблице бд
    protected $_dbTable;
    
    /**
     * устанавливает $_dbTable
     *
     * @param string $dbTable
     * @return Application_Model_BeveragesMapper $this
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
            $this->setDbTable('Application_Model_DbTable_Beverages');
        }
        return $this->_dbTable;
    }
    
    /**
     * создает объект напитка
     *
     * @param Object $row
     * @return Application_Model_Beverages $beverage
     */
    private function createBeverage($row){
        $beverage = new Application_Model_Beverages();
        $beverage->setId($row->id)
                 ->setName($row->name)
                 ->setDescription($row->description);
        return $beverage;
    }
    
    /**
     * сохраняет напиток
     *
     * @param Application_Model_Beverages $beverage
     * @return Application_Model_Beverages $beverage
     */
    public function save(Application_Model_Beverages $beverage)
    {
        $data = array(
            'name'   => $beverage->getName(),
            'description' => $beverage->getDescription()
        );
        // если напитка не существовало, то добавляем строку в бд
        // и устанавливаем объекту соответствующий id 
        if (null === ($id = $beverage->getId())) {
            $id = $this->getDbTable()->insert($data);
            $beverage->setId($id);
        } else {
            // если существовал, то делаем update
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
        return $beverage;
    }
    
    /**
     * находит напиток
     *
     * @param integer $id
     * @return Application_Model_Beverages $beverage
     */
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
    
    /**
     * удаляет напиток
     *
     * @param Application_Model_Beverages $beverage
     * @param bool $success
     */
    public function delete(Application_Model_Beverages $beverage){
        return $this->getDbTable()->delete('id = ' . $beverage->id);
    }
    
    /**
     * находит все напитки
     *
     * @return array of Application_Model_Beverages $beverages
     */
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $beverages   = array();
        foreach ($resultSet as $row) {
            $beverages[] = $this->createBeverage($row);
        }
        return $beverages;
    }
    
    /**
     * создаёт документ поиска
     *
     * @param Object $row
     * @return Application_Model_SearchDoc
     */
    private function createSearchDoc($row){
        $doc = new Application_Model_SearchDoc();
        $doc->setId($row->id)
            ->setTitle($row->name)
            ->setContent($row->description)
            ->setType('beverages');
        return $doc;
    }
    
    /**
     * находит напиток как документ для поиска
     *
     * @param integer $id
     * @return Application_Model_SearchDoc $searchDoc
     */
    public function findSearchDoc($id)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $searchDoc = $this->createSearchDoc($row);
        return $searchDoc;
    }
    
    /**
     * находит все напитки как документы для поиска
     *
     * @return array of Application_Model_SearchDoc $searchDocs
     */
    public function fetchAllSearchDocs()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $searchDocs   = array();
        foreach ($resultSet as $row) {
            $searchDocs[] = $this->createSearchDoc($row);
        }
        return $searchDocs;
    }
}

