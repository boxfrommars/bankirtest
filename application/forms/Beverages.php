<?php

class Application_Form_Beverages extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
 
        $this->addElement('text', 'name', array(
            'label'      => "beverage's name:",
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array()
        ));

        $this->addElement('textarea', 'description', array(
            'label'      => 'description of the beverage:',
            'required'   => true,
            'validators' => array()
        ));
 
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'сохранить',
        ));
        
        $this->addElement('hidden', 'id', array(
            'validators' => array('digits'),
            'required' => false
        ));
    }
}

