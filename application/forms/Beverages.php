<?php

class Application_Form_Beverages extends Zend_Form
{

    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');
 
        // Add an email element
        $this->addElement('text', 'name', array(
            'label'      => "beverage's name:",
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array()
        ));

        // Add the comment element
        $this->addElement('textarea', 'description', array(
            'label'      => 'description of the beverage:',
            'required'   => true,
            'validators' => array()
        ));
 
        // Add the submit button
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

