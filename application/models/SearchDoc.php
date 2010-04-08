<?php

class Application_Model_SearchDoc
{
    public $_modelName = "search doc";
    
    protected $_title;
    protected $_content;
    protected $_type;
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
            throw new Exception("Invalid {$this->_modelName} property");
        }
        $this->$method($value);
    }
 
    /**
     * позволяет обращаться к приватным свойствам ($beverage->foo) извне.
     * перенаправляет через соответствующий геттер ($beverage->getFoo())
     *
     * @param mixed $propertyName
     */
    public function __get($name)
    {
        $method = 'get' . $name;
        if (!method_exists($this, $method)) {
            throw new Exception("Invalid {$this->_modelName} property");
        }
        return $this->$method();
    }
 
    /**
     * устанавливает свойства объектов используя массив настроек
     * с помощью соответствующих ключам сеттеров. (напр. array('key' => 'foo'), $this->setKey(foo))
     *
     * @param array $options
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
     * @param string $title
     * @return Application_Model_SearchDoc $this
     */
    public function setTitle($title)
    {
        $this->_title = (string) $title;
        return $this;
    }
 
    public function getTitle()
    {
        return $this->_title;
    }
 
    /**
     * @param string $content
     * @return Application_Model_SearchDoc $this
     */
    public function setContent($content)
    {
        $this->_content = (string) $content;
        return $this;
    }
 
    public function getContent()
    {
        return $this->_content;
    }
 
    /**
     * @param string $type
     * @return Application_Model_SearchDoc $this
     */
    public function setType($type)
    {
        $this->_type = (int) $type;
        return $this;
    }
 
    public function getType()
    {
        return $this->_type;
    }
 
    /**
     * @param integer $id
     * @return Application_Model_SearchDoc $this
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

