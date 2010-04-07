<?php
/**
 * форма для добавления заполненых бутылок
 */
class Application_Form_FilledBottle extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');
        
        // инпут для этикетки
        $this->addElement('text', 'name', array(
            'label'      => "label:",
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array()
        ));
        
        // селект для типов бутылок
        $this->addElement('select', 'bottle_id', array(
            'label'      => 'bottle:',
            'required'   => true,
            'validators' => array('digits')
        ));
        $bottleSelect = $this->getElement('bottle_id');
        
        // маппер для бутылок
        $bottles = new Application_Model_BottlesMapper();
        // получаем все бутылки
        $allBottles = $bottles->fetchAll();
        // добавлям бутылки в options селекта
        foreach ($allBottles as $bottle){
            $bottleSelect->addMultiOption($bottle->id, $bottle->name);
        }
        
        // селект для напитков
        $this->addElement('select', 'beverage_id', array(
            'label'      => 'beverage:',
            'required'   => true,
            'validators' => array('digits')
        ));
        $beverageSelect = $this->getElement('beverage_id');
        
        // маппер для напитков
        $beverages = new Application_Model_BeveragesMapper();
        // получаем все напитки
        $allBeverages = $beverages->fetchAll();
        // добавляем напитки в options селекта
        foreach ($allBeverages as $beverage){
            $beverageSelect->addMultiOption($beverage->id, $beverage->name);
        }
        
        // сабмит
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'сохранить',
        ));
    }


}

