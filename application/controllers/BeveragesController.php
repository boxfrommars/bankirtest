<?php
/**
* контроллер напитков. позволяет просматривать напитки списком,
* отдельные напитки, редактировать и удалять напитки. все изменения напитков
* автоматически изменяют поисковый индекс
*/
class BeveragesController extends Zend_Controller_Action
{
    // маппер для напитков
    protected $beverages;

    public function init()
    {
        $this->beverages = new Application_Model_BeveragesMapper();
    }
    
    /**
    * просмотр списка и добавление напитков
    */
    public function indexAction()
    {
        // создаём форму добавления напитка
        $form = new Application_Form_Beverages();
        // т.к. мы добавляем напиток, удаляем поле id
        $form->removeElement('id');
        
        // если есть данные, переданные с помощью метода POST,
        if ($this->getRequest()->isPost()) {
            
            $request = $this->getRequest();
            // и если они валидны, сохраняем напиток и добавляем документ для поиска в поисковый индекс
            if ($form->isValid($request->getPost())) {
                $beverage = new Application_Model_Beverages($form->getValues());
                $beverage = $this->beverages->save($beverage);
                
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
        
        // получаем список всех напитков и передаём в вид
        $this->view->entries = $this->beverages->fetchAll();
        $this->view->form = $form;
    }

    /**
    * просмотр отдельного напитка
    */
    public function viewAction()
    {
        // получаем id напитка (используется роутер beverages, см. конфиг в /configs/routes.ini)
        $beverageId = $this->_getParam('beverageId');
                
        if (is_numeric($beverageId)){
            $beverage = $this->beverages->find($beverageId);
            
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

    /**
    * редактирование напитка
    */
    public function editAction()
    {
        // получаем id напитка (используется роутер editbeverages, см. конфиг в /configs/routes.ini)
        $beverageId = $this->_getParam('beverageId');
        
        if (is_numeric($beverageId)){
            $beverage = $this->beverages->find($beverageId);
            
            // если нашли напиток с данным id, то показываем его
            // если нет, показываем 404
            if (null != $beverage){
                $form = new Application_Form_Beverages();
                
                // если есть переданные postом данные
                if ($this->getRequest()->isPost()) {
                    $request = $this->getRequest();
                    
                    // и они валидны
                    if ($form->isValid($request->getPost())) {
                        // создаём объект напитка с данными полученными из формы 
                        $beverage = new Application_Model_Beverages($form->getValues());
                        // сохраняем напиток
                        $this->beverages->save($beverage);
                        
                        // обновляем поисковый индекс (см. примечание к индекс-экшну)
                        $searchDoc = new Application_Model_SearchDoc();
                        $searchDoc->setId($beverage->id)
                            ->setContent($beverage->description)
                            ->setTitle($beverage->name)
                            ->setType('beverage');
                        $search = new Application_Model_Search();
                        $search->updateInIndex($searchDoc);
                        
                        // направляемся на страницу этого напитка
                        return $this->_helper->redirector->gotoRoute(
                            array(
                                'action' => 'view',
                                'controller' => 'beverages',
                                'beverageId' => $beverage->id,
                            ), 'beverages'
                        );
                    }
                } else {
                    // если переданных данных нет, то добавляем
                    // в форму для редактирования данные напитка
                    $form->setDefaults(array(
                                             'name' => $beverage->name,
                                             'description' => $beverage->description,
                                             'id' => $beverage->id
                                        ));
                }
                // отправляем в вид форму и напиток
                $this->view->form = $form;
                $this->view->beverage = $beverage;
                
            } else {
               throw new Zend_Controller_Action_Exception('beverage not found', 404);
            }
             
        } else {
           throw new Zend_Controller_Action_Exception('invalid format of beverage id: '.$bottleId, 404);
        }
    }

    /**
    * удаление напитка
    */
    public function deleteAction()
    {
        // получаем id напитка (используется роутер deletebeverages, см. конфиг в /configs/routes.ini)
        $beverageId = $this->_getParam('beverageId');
                
        if (is_numeric($beverageId)){
            $beverage = $this->beverages->find($beverageId);
            
            if (null != $beverage){
                $form = new Application_Form_DeleteBeverages();
                    
                if ($this->getRequest()->isPost()) {
                    $request = $this->getRequest();
                    
                    if ($form->isValid($request->getPost())) {
                        // если всё в порядке, создаём объект напитка
                        $beverage = new Application_Model_Beverages();
                        $formValues = $form->getValues();
                        $beverage->setId($formValues['id']);
                        // удаляем напиток
                        $this->beverages->delete($beverage);
                        
                        
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





