<?php

class FilledbottlesController extends Zend_Controller_Action
{

    public function init()
    {
        $filledBottles = new Application_Model_FilledBottlesMapper();
        $form = new Application_Form_FilledBottle();
        
        if ($this->getRequest()->isPost()) {
            
            $request = $this->getRequest();
            if ($form->isValid($request->getPost())) {
                $formValues = $form->getValues();
                
                $bottle = new Application_Model_Bottles();
                $bottle->setId($formValues['bottle_id']);
                
                $beverage = new Application_Model_Beverages();
                $beverage->setId($formValues['beverage_id']);
                
                $filledBottle = new Application_Model_FilledBottles();
                $filledBottle->setName($formValues['name']);
                $filledBottle->setBeverage($beverage);
                $filledBottle->setBottle($bottle);
                
                $mapper = new Application_Model_FilledBottlesMapper();
                $mapper->save($filledBottle);
                
                return $this->_helper->redirector('index');
            }
        }
        
        $this->view->filledBottles = $filledBottles->fetchAll();
        $this->view->form = $form;
    }

    public function indexAction()
    {
        // action body
    }


}

