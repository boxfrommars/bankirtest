<?php
/**
 * форма для добавления/редактирования напитка
 */
class Application_Form_Beverages extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        
        // инпут для имени напитка
        $this->addElement('text', 'name', array(
            'label'      => "beverage's name:",
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array()
        ));
        
        // textarea для описания
        $this->addElement('textarea', 'description', array(
            'label'      => 'description of the beverage:',
            'required'   => true,
            'validators' => array()
        ));
 
        // сабмит
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'сохранить',
        ));
        
        // скрытое поле для id
        $this->addElement('hidden', 'id', array(
            'validators' => array('digits'),
            'required' => false
        ));
    }
}

