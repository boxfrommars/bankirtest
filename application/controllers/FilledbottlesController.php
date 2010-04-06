<?php

class FilledbottlesController extends Zend_Controller_Action
{

    public function init()
    {
        $filledBottles = new Application_Model_FilledBottlesMapper();
        /* show all bottles */
        $this->view->filledBottles = $filledBottles->fetchAll();
    }

    public function indexAction()
    {
        // action body
    }


}

