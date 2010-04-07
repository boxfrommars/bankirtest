<?php
/**
* просмотр бутылок: как списком, так и по отдельности
*/
class BottlesController extends Zend_Controller_Action
{
    // маппер для бутылок
    protected $bottles;

    public function init()
    {
        $this->bottles = new Application_Model_BottlesMapper();
    }

    public function indexAction()
    {
        // отправляем в вид все бутылки
        $this->view->bottles = $this->bottles->fetchAll();
    }

    public function viewAction()
    {
        // получаем id бутылки (используется роутер editbeverages, см. конфиг в /configs/routes.ini)
        $bottleId = $this->_getParam('bottleId');
        if (is_numeric($bottleId)){
            // находим бутылку
            $bottle = $this->bottles->find($bottleId);
            
            // если нашли — показываем, если нет, то показываем 404
            if (null != $bottle){
               $this->view->bottle = $bottle;
            } else {
               throw new Zend_Controller_Action_Exception('bottle not found', 404);
            }
        } else {
           throw new Zend_Controller_Action_Exception('invalid format of bottle id: '.$bottleId, 404);
        }
        
        // проверяем, запрашивается ли страница с помощью ajax,
        // если да, то отключаем лайаут
        if($this->_request->isXmlHttpRequest()) {
            $this->_helper->layout()->disableLayout();
        }
    }
}



