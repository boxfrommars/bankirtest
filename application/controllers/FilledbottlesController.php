<?php

class FilledbottlesController extends Zend_Controller_Action
{

    public function init()
    {
        $bottles = new Application_Model_FilledBottlesMapper();
        /* show all bottles */
        $this->view->bottles = $bottles->fetchAll();
    }

    public function indexAction()
    {
        // action body
    }


}

