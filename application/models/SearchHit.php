<?php

class Application_Model_SearchHit
{
    public $_modelName = "search hit";
    
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
 
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (!method_exists($this, $method)) {
            throw new Exception("Invalid {$this->_modelName} property");
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (!method_exists($this, $method)) {
            throw new Exception("Invalid {$this->_modelName} property");
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
 
    public function setTitle($name)
    {
        $this->_title = (string) $title;
        return $this;
    }
 
    public function getTitle()
    {
        return $this->_title;
    }
 
    public function setContent($content)
    {
        $this->_content = (string) $content;
        return $this;
    }
 
    public function getContent()
    {
        return $this->_content;
    }
 
    public function setType($type)
    {
        $this->_type = (int) $type;
        return $this;
    }
 
    public function getType()
    {
        return $this->_type;
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

}

