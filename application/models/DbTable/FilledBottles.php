<?php

class Application_Model_DbTable_FilledBottles extends Zend_Db_Table_Abstract
{

    protected $_name = 'filled_bottles';
    
    // каждая пара соответствует foo.bar AS foo_bar, подставляется в запрос 
    protected $_bottle = array(
        'bottle_name' => 'name',
        'bottle_id' => 'id',
        'bottle_img_src' => 'img_src',
        'bottle_description' => 'description'
    );
    
    // каждая пара соответствует foo.bar AS foo_bar, подставляется в запрос 
    protected $_beverage = array(
        'beverage_name' => 'name',
        'beverage_id' => 'id',
        'beverage_description' => 'description'
    );
    
    /**
     * возвращает массив всех заполненных бутылок полученных из бд
     *
     * @return array of Objects $obj
     */
    public function fetchAllFull()
    {
        $select = $this->getAdapter()->select()
                ->from(array('fb' => $this->_name), 'name')
                ->join(array('b' => 'bottles'), 'fb.bottle_id = b.id', $this->_bottle)
                ->join(array('bv' => 'beverages'), 'fb.beverage_id = bv.id', $this->_beverage);
        return $this->getAdapter()->query($select)->fetchAll(Zend_Db::FETCH_OBJ);
    }
    
    /**
     * возвращает массив всех заполненных бутылок полученных из бд
     *
     * @param integer $id
     * @return array of Objects $obj
     */
    public function findFull($id)
    {
        $select = $this->getAdapter()->select()
                ->from(array('fb' => $this->_name), 'name')
                ->join(array('b' => 'bottles'), 'fb.bottle_id = b.id', $this->_bottle)
                ->join(array('bv' => 'beverages'), 'fb.beverage_id = bv.id', $this->_beverage)
                ->where('id = ?', $id);
        return $this->getAdapter()->query($select)->fetchAll(Zend_Db::FETCH_OBJ);
        
    }
}

