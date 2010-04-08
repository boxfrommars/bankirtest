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
 
    /**
     * позволяет изменять приватные свойства ($beverage->foo = bar) извне.
     * перенаправляет через соответствующий сеттер ($beverage->setFoo(bar)) 
     *
     * @param Mixed $propertyName
     */
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (!method_exists($this, $method)) {
            throw new Exception('Invalid filled bottle property');
        }
        $this->$method($value);
    }
 
    /**
     * позволяет обращаться к приватным свойствам ($beverage->foo) извне.
     * перенаправляет через соответствующий геттер ($beverage->getFoo())
     *
     * @param Mixed $propertyName
     */
    public function __get($name)
    {
        $method = 'get' . $name;
        if (!method_exists($this, $method)) {
            throw new Exception('Invalid filled bottle property');
        }
        return $this->$method();
    }
 
    /**
     * устанавливает свойства объектов используя массив настроек
     * с помощью соответствующих ключам сеттеров. (напр. array('key' => 'foo'), $this->setKey(foo))
     *
     * @param Array $options
     */
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
 
    /**
     * @param String $name
     * @return Application_Model_FilledBottles $this
     */
    public function setName($name)
    {
        $this->_name = (string) $name;
        return $this;
    }
 
    public function getName()
    {
        return $this->_name;
    }
 
    /**
     * @param Integer $id
     * @return Application_Model_FilledBottles $this
     */
    public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }
 
    public function getId()
    {
        return $this->_id;
    }
    
    /**
     * @param Application_Model_Bottles $bottle
     * @return Application_Model_FilledBottles $this
     */
    public function setBottle(Application_Model_Bottles $bottle)
    {
        $this->_bottle = $bottle;
        return $this;
    }
    
    public function getBottle()
    {
        return $this->_bottle;
    }
    
    /**
     * @param Application_Model_Beverages $beverage
     * @return Application_Model_FilledBottles $this
     */
    public function setBeverage(Application_Model_Beverages $beverage)
    {
        $this->_beverage = $beverage;
        return $this;
    }
    
    public function getBeverage()
    {
        return $this->_beverage;
    }

}

