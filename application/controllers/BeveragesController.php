<?php

class BeveragesController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $form = new Application_Form_Beverages();
        $form->removeElement('id');
        
        if ($this->getRequest()->isPost()) {
            
            $request = $this->getRequest();
            if ($form->isValid($request->getPost())) {
                $beverage = new Application_Model_Beverages($form->getValues());
                $mapper = new Application_Model_BeveragesMapper();
                $mapper->save($beverage);
                return $this->_helper->redirector('index');
            }
        }
        
        $beverages = new Application_Model_BeveragesMapper();
        
        $this->view->entries = $beverages->fetchAll();
        $this->view->form = $form;
    }

    public function addAction()
    {
        //$layout = $this->_helper->layout();
                        //$layout->disableLayout();
    }

    public function viewAction()
    {
        $beverageId = $this->_getParam('beverageId');
        
        if (is_numeric($beverageId)){
            
            $beverages = new Application_Model_BeveragesMapper();
            
            /* find beverage by id */
            $beverage = $beverages->find($beverageId);
            
            /* if beverage exist */
            if (null != $beverage){
                
                $this->view->beverage = $beverage;
                
            } else {
                
                /* if beverage is missing, show page404 */
               throw new Zend_Controller_Action_Exception('beverage not found', 404);
            }
             
        } else {
           throw new Zend_Controller_Action_Exception('invalid format of beverage id: '.$bottleId, 404);
        }
    }

    public function editAction()
    {
        $beverageId = $this->_getParam('beverageId');
        
        if (is_numeric($beverageId)){
            
            $beverages = new Application_Model_BeveragesMapper();
            /* find beverage by id */
            $beverage = $beverages->find($beverageId);
            
            /* if beverage exist */
            if (null != $beverage){
                
                $form = new Application_Form_Beverages();
                    
                if ($this->getRequest()->isPost()) {
                    $request = $this->getRequest();
                    
                    if ($form->isValid($request->getPost())) {
                        $beverage = new Application_Model_Beverages($form->getValues());
                        $mapper = new Application_Model_BeveragesMapper();
                        $mapper->save($beverage);
                        return $this->_helper->redirector->gotoRoute(
                            array('action' => 'view',
                                  'controller' => 'beverages',
                                  'beverageId' => $beverage->id,
                                  ),
                            'beverages'
                        );
                    }
                } else {
                    $form->setDefaults(array(
                                             'name' => $beverage->name,
                                             'description' => $beverage->description,
                                             'id' => $beverage->id
                                        ));
                }
                
                $this->view->form = $form;
                $this->view->beverage = $beverage;
                
            } else {
                /* if beverage is missing, show page404 */
               throw new Zend_Controller_Action_Exception('beverage not found', 404);
            }
             
        } else {
           throw new Zend_Controller_Action_Exception('invalid format of beverage id: '.$bottleId, 404);
        }
            
        
    }


}



