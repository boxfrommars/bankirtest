<?php

class Application_Form_FilledBottle extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
 
        $this->addElement('text', 'name', array(
            'label'      => "label:",
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array()
        ));

        $this->addElement('select', 'bottle', array(
            'label'      => 'bottle:',
            'required'   => true,
            'validators' => array('digits')
        ));
        $bottleSelect = $this->getElement('bottle');
        
        $bottles = new Application_Model_BottlesMapper();
        $allBottles = $bottles->fetchAll(); 
        foreach ($allBottles as $bottle){
            $bottleSelect->addMultiOption($bottle->id, $bottle->name);
        }
        
        
        $this->addElement('select', 'beverage', array(
            'label'      => 'beverage:',
            'required'   => true,
            'validators' => array('digits')
        ));
 
        $beverageSelect = $this->getElement('beverage');
        
        $beverages = new Application_Model_BeveragesMapper();
        $allBeverages = $beverages->fetchAll(); 
        foreach ($allBeverages as $beverage){
            $beverageSelect->addMultiOption($beverage->id, $beverage->name);
        }
        
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'сохранить',
        ));
    }


}

