<?php
/**
 * Модель напитка
 */
class Application_Model_Beverages
{
    // название бутылки
    protected $_name;
    // описание
    protected $_description;
    // id
    protected $_id;
 
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
     * @param string $propertyName
     * @param mixed $propertyValue
     */
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (!method_exists($this, $method)) {
            throw new Exception('Invalid beverages property');
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
            throw new Exception('Invalid beverages property');
        }
        return $this->$method();
    }

    /**
     * устанавливает свойства объектов используя массив настроек
     * с помощью соответствующих ключам сеттеров. (напр. array('key' => 'foo'), $this->setKey(foo))
     *
     * @param Array $options
     * @return Application_Model_Beverages $this
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
     * @return Application_Model_Beverages $this
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
     * @param String $description
     * @return Application_Model_Beverages $this
     */
    public function setDescription($description)
    {
        $this->_description = (string) $description;
        return $this;
    }
 
    public function getDescription()
    {
        return $this->_description;
    }
 
    /**
     * @param Integer $id
     * @return Application_Model_Beverages $this
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

}

