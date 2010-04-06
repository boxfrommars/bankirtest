<?php

class Application_Model_FilledBottles
{
    protected $_id;
    protected $_name;
    protected $_bottle;
    protected $_beverage;
 
    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
 
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (!method_exists($this, $method)) {
            throw new Exception('Invalid filled bottle property');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (!method_exists($this, $method)) {
            throw new Exception('Invalid filled bottle property');
        }
        return $this->$method();
    }
 
    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
 
    public function setName($name)
    {
        $this->_name = (string) $name;
        return $this;
    }
 
    public function getName()
    {
        return $this->_name;
    }
 
    public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }
 
    public function getId()
    {
        return $this->_id;
    }
    
    public function setBottle($row)
    {
        $bottle = new Application_Model_Bottles();
        $bottle->setId($row->bottle_id)
                ->setName($row->bottle_name)
                ->setDescription($row->bottle_description)
                ->setImg($row->bottle_img_src);
        
        $this->_bottle = $bottle;
        
        return $this;
    }
    
    public function getBottle()
    {
        return $this->_bottle;
    }
    
    public function setBeverage($row)
    {
        $beverage = new Application_Model_Beverages();
        $beverage->setId($row->beverage_id)
                ->setName($row->beverage_name)
                ->setDescription($row->beverage_description);
        
        $this->_beverage = $beverage;
        
        return $this;
    }
    
    public function getBeverage()
    {
        return $this->_beverage;
    }

}

