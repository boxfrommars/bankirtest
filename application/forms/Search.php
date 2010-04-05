<?php

class Application_Form_Search extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        
        $this->addElement('text', 'searchstring', array(
                                                        'label' => 'Search',
                                                        'required'   => true,
                                                        'filters'    => array('StringTrim'),
                                                        'validators' => array()
                                                        ));
        $this->addElement('submit', 'submit', array(
                                                    'ignore' => true,
                                                    'label' => 'Искать'
                                                    ));
    }


}

