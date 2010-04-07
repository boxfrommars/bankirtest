<?php

class BeveragesController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $beverages = new Application_Model_BeveragesMapper();
        $form = new Application_Form_Beverages();
        $form->removeElement('id');
        
        // если есть данные, переданные с помощью метода POST,
        if ($this->getRequest()->isPost()) {
            
            $request = $this->getRequest();
            // и если они валидны, сохраняем напиток и добавляем документ для поиска в поисковый индекс
            if ($form->isValid($request->getPost())) {
                $beverage = new Application_Model_Beverages($form->getValues());
                $beverage = $beverages->save($beverage);
                
                // вообще — это не очень правильно добавлять документы в поиск сразу после их добавления в базу.
                // лучше пользоваться плановым добавлением (например, раз в 2 часа)
                $searchDoc = new Application_Model_SearchDoc();
                $searchDoc->setId($beverage->id)
                    ->setContent($beverage->description)
                    ->setTitle($beverage->name)
                    ->setType('beverage');
                
                $search = new Application_Model_Search();
                $search->addToIndex($searchDoc);
                
                // направляемся на дефолтный экшн контроллера
                return $this->_helper->redirector('index');
            }
        }
        
        
        $this->view->entries = $beverages->fetchAll();
        $this->view->form = $form;
    }

    public function viewAction()
    {
        $beverageId = $this->_getParam('beverageId');
                
        if (is_numeric($beverageId)){
            $beverages = new Application_Model_BeveragesMapper();
            $beverage = $beverages->find($beverageId);
            
            // если нашли напиток с данным id, то показываем его
            // если нет, показываем 404
            if (null != $beverage){
                $this->view->beverage = $beverage;
            } else {
               throw new Zend_Controller_Action_Exception('beverage not found', 404);
            }
             
        } else {
           throw new Zend_Controller_Action_Exception('invalid format of beverage id: '.$beverageId, 404);
        }
        
        // проверяем, запрашивается ли страница с помощью ajax,
        // если да, то отключаем лайаут
        if($this->_request->isXmlHttpRequest()) {
            $this->_helper->layout()->disableLayout();
        }
    }

    public function editAction()
    {
        $beverageId = $this->_getParam('beverageId');
        
        if (is_numeric($beverageId)){
            $beverages = new Application_Model_BeveragesMapper();
            $beverage = $beverages->find($beverageId);
            
            // если нашли напиток с данным id, то показываем его
            // если нет, показываем 404
            if (null != $beverage){
                $form = new Application_Form_Beverages();
                
                // если есть переданные postом данные
                if ($this->getRequest()->isPost()) {
                    $request = $this->getRequest();
                    
                    // и они валидны
                    if ($form->isValid($request->getPost())) {
                        $beverage = new Application_Model_Beverages($form->getValues());
                        // сохраняем напиток
                        $beverages->save($beverage);
                        
                        // обновляем поисковый индекс (см. примечание к индекс-экшну)
                        $searchDoc = new Application_Model_SearchDoc();
                        $searchDoc->setId($beverage->id)
                            ->setContent($beverage->description)
                            ->setTitle($beverage->name)
                            ->setType('beverage');
                        
                        $search = new Application_Model_Search();
                        $search->updateInIndex($searchDoc);
                        
                        // и направляемся на страницу этого напитка
                        return $this->_helper->redirector->gotoRoute(
                            array('action' => 'view',
                                  'controller' => 'beverages',
                                  'beverageId' => $beverage->id,
                                  ), 'beverages'
                        );
                    }
                } else {
                    // если переданных данных нет, то добавляем в форму данные напитка
                    $form->setDefaults(array(
                                             'name' => $beverage->name,
                                             'description' => $beverage->description,
                                             'id' => $beverage->id
                                        ));
                }
                
                $this->view->form = $form;
                $this->view->beverage = $beverage;
                
            } else {
               throw new Zend_Controller_Action_Exception('beverage not found', 404);
            }
             
        } else {
           throw new Zend_Controller_Action_Exception('invalid format of beverage id: '.$bottleId, 404);
        }
    }

    public function deleteAction()
    {
        $beverageId = $this->_getParam('beverageId');
                
        if (is_numeric($beverageId)){
            $beverages = new Application_Model_BeveragesMapper();
            $beverage = $beverages->find($beverageId);
            
            if (null != $beverage){
                $form = new Application_Form_DeleteBeverages();
                    
                if ($this->getRequest()->isPost()) {
                    $request = $this->getRequest();
                    
                    if ($form->isValid($request->getPost())) {
                        $beverage = new Application_Model_Beverages();
                        $formValues = $form->getValues();
                        $beverage->setId($formValues['id']);
                        $beverages->delete($beverage);
                        
                        
                        // обновляем поисковый индекс (см. примечание к индекс-экшну)
                        $searchDoc = new Application_Model_SearchDoc();
                        $searchDoc->setId($beverage->id);
                        
                        $search = new Application_Model_Search();
                        $search->deleteFromIndex($searchDoc);
                        
                        return $this->_helper->redirector('index');
                    }
                } else {
                    $form->setDefaults(array('id' => $beverage->id));
                }
                
                $this->view->form = $form;
                $this->view->beverage = $beverage;
                
            } else {
               throw new Zend_Controller_Action_Exception('beverage not found', 404);
            }
             
        } else {
           throw new Zend_Controller_Action_Exception('invalid format of beverage id: '.$bottleId, 404);
        }
    }
}





