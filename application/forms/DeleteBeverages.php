<?php
/**
 * форма для удаления напитков, содержит только сабмит и скрытое поле с id напитка
 */
class Application_Form_DeleteBeverages extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'да, удалить',
        ));
        
        $this->addElement('hidden', 'id', array(
            'validators' => array('digits'),
            'required' => false
        ));
    }


}

