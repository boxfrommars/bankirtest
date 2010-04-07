<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->headScript()->appendFile('/js/fallingbottles.js', 'text/javascript');
        
        $filledBottles = new Application_Model_FilledBottlesMapper();
        $this->view->filledBottles = $filledBottles->fetchAll();
    }

}

