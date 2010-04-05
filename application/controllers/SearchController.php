<?php

class SearchController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    /**
     * Search documents containing the string passed by $_POST['searchstring']
     *
     */
    public function indexAction()
    {
        $form = new Application_Form_Search();
        $this->view->searchForm = $form;
        
        if ($this->getRequest()->isPost()) {
            
            $request = $this->getRequest();
            if ($form->isValid($request->getPost())) {
                $values = $form->getValues();
                $searchString = $values['searchstring'];
                
                $search = new Application_Model_Search();
                $hits = $search->search($searchString);
                
                $this->view->searchString = $searchString;
                $this->view->searchResult = $hits;
            }
        }
    }
    /**
     * Update all index
     *
     */
    public function updateIndexAction()
    {
        $search = new Application_Model_Search();
        $search->updateIndex();
    }
    
    /**
     * Create search index
     *
     */
    public function createIndexAction()
    {
        $search = new Application_Model_Search();
        $search->createIndex();
    }


}





