<?php
/**
* контроллер наполенных бутылок. позволяет просматривать списком, добавлять
* и удалять нап.бутылки 
*/
class FilledbottlesController extends Zend_Controller_Action
{
    // маппер
    protected $filledBottles;
    // флеш-мессенджер
    protected $_flashMessenger;
    
    public function init()
    {
        $this->filledBottles = new Application_Model_FilledBottlesMapper();
        // получаем флеш-сообщения
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
        $this->view->flashmessage = $this->_flashMessenger->getMessages();
    }

    public function indexAction()
    {
        // форма для добавления нап.бутылок
        $form = new Application_Form_FilledBottle();
        
        // если есть post данные
        if ($this->getRequest()->isPost()) {
            
            $request = $this->getRequest();
            // и они валидны
            if ($form->isValid($request->getPost())) {
                
                // создаём объект нап.бутылки (попутно объект её бутылки и напитка)
                $formValues = $form->getValues();
                
                $filledBottle = new Application_Model_FilledBottles();
                $bottle = new Application_Model_Bottles();
                $bottle->setId($formValues['bottle_id']);
                
                $beverage = new Application_Model_Beverages();
                $beverage->setId($formValues['beverage_id']);
                
                $filledBottle->setName($formValues['name'])
                            ->setBeverage($beverage)
                            ->setBottle($bottle);
                
                // сохраняем новую нап.бутылку
                $this->filledBottles->save($filledBottle);
                // добавляем сообщение об удачном добавлении
                $this->_flashMessenger->addMessage('Наполненная бутылка ' . $filledBottle->getName() . ' добавлена');
                
                return $this->_helper->redirector('index');
            }
        }
        
        // отправляем нап.бутылку и форму в вид
        $this->view->filledBottles = $this->filledBottles->fetchAll();
        $this->view->form = $form;
    }


}

