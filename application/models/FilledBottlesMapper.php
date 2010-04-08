<?php

class Application_Model_FilledBottlesMapper
{
    // интерфейс к таблице бд
    protected $_dbTable;
 
    /**
     * устанавливает $_dbTable
     *
     * @param string $dbTable
     * @return Application_Model_FilledBottlesMapper $this
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
            $this->setDbTable('Application_Model_DbTable_FilledBottles');
        }
        return $this->_dbTable;
    }

    /**
     * создает объект наполненной бутылки
     *
     * @param Object $row
     * @return Application_Model_FilledBottles $bottle
     */
    private function createFilledBottle($row){
        
        // создаём объект бутылки
        $bottle = new Application_Model_Bottles();
        $bottle->setId($row->bottle_id)
                ->setName($row->bottle_name)
                ->setDescription($row->bottle_description)
                ->setImg($row->bottle_img_src);
        
        // создаём объект напитка
        $beverage = new Application_Model_Beverages();
        $beverage->setId($row->beverage_id)
                ->setName($row->beverage_name)
                ->setDescription($row->beverage_description);
        
        // создаём объект наполненной бутылки
        $filledBottle = new Application_Model_FilledBottles();        
        $filledBottle->setId($row->id)
                ->setName($row->name)
                ->setBottle($bottle)
                ->setBeverage($beverage);
                
        return $filledBottle;
    }

    /**
     * находит нап.бутылку
     *
     * @param integer $id
     * @return Application_Model_FilledBottles $bottle
     */
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
    
    /**
     * сохраняет нап.бутылку
     *
     * @param Application_Model_FilledBottles $bottle
     * @return Application_Model_FilledBottles $bottle
     */
    public function save(Application_Model_FilledBottles $filledBottle)
    {
        $data = array(
            'name'   => $filledBottle->name,
            'beverage_id'   => $filledBottle->beverage->id,
            'bottle_id' => $filledBottle->bottle->id
        );
        // если нап.бутылка новая, то добавляем её и устанавливаем
        // ей соотв. id
        if (null === ($id = $filledBottle->getId())) {
            $id = $this->getDbTable()->insert($data);
            $filledBottle->setId($id);
        } else {
            // если нап.бутылка существовала, то апдейтим
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
        return $filledBottle;
    }
    
    /**
     * находит все нап.бутылки
     *
     * @return array of Application_Model_FilledBottles $bottle
     */
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

