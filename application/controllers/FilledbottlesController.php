<?php

class FilledbottlesController extends Zend_Controller_Action
{

    public function init()
    {
        $filledBottles = new Application_Model_FilledBottlesMapper();
        $form = new Application_Form_FilledBottle();
        
        $this->view->filledBottles = $filledBottles->fetchAll();
        $this->view->form = $form;
    }

    public function indexAction()
    {
        // action body
    }


}

