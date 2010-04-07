<?php
/**
* контроллер позволяющий производить поиск по индексу
*/
class SearchController extends Zend_Controller_Action
{

    public function init()
    {
        $layout = $this->_helper->layout();
    }

    /**
     * ищет документы с соответствием со строкой переданной в $_POST['searchstring']
     */
    public function indexAction()
    {
        // форма поиска
        $form = new Application_Form_Search();
        $this->view->searchForm = $form;
        
        // если есть post-данные и они валидны
        if ($this->getRequest()->isPost()) {
            $request = $this->getRequest();
            if ($form->isValid($request->getPost())) {
                // получаем строку для поиска
                $values = $form->getValues();
                $searchString = $values['searchstring'];
                
                // ищем
                $search = new Application_Model_Search();
                $hits = $search->search($searchString);
                
                // отправляем в вид строку поиска и результат
                $this->view->searchString = $searchString;
                $this->view->searchResult = $hits;
            }
        }
    }
}





