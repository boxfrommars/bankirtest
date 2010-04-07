<?php
/**
* индекс-контроллер, показывает все наполненные бутылки в забавной форме  
*/
class IndexController extends Zend_Controller_Action
{
    public function init()
    {
    }

    public function indexAction()
    {
        // добавляем в лайаут js-скрипт для управления песней и бутылками
        $this->view->headScript()->appendFile('/js/fallingbottles.js', 'text/javascript');
        
        // отправляем в вид вс наполненные бутылки
        $filledBottles = new Application_Model_FilledBottlesMapper();
        $this->view->filledBottles = $filledBottles->fetchAll();
    }

}

