<?php

class BottlesController extends Zend_Controller_Action
{

    public function init()
    {
        
    }

    public function indexAction()
    {
        $bottles = new Application_Model_BottlesMapper();
        /* show all bottles */
        $this->view->bottles = $bottles->fetchAll();
    }

    public function viewAction()
    {
        
        $bottleId = $this->_getParam('bottleId');
        if (is_numeric($bottleId)){
            $bottles = new Application_Model_BottlesMapper();
            
            /* find bottle by id */
            $bottle = $bottles->find($bottleId);
            if (null != $bottle){
               $this->view->bottle = $bottle;
            } else {
                /* if bottle is missing, show page404 */
               throw new Zend_Controller_Action_Exception('bottle not found', 404);
            }
             
        } else {
           throw new Zend_Controller_Action_Exception('invalid format of bottle id: '.$bottleId, 404);
        }
        
        if($this->_request->isXmlHttpRequest()) {
            $this->_helper->layout()->disableLayout();
        }
        
    }


}



