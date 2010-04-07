<?php
/**
* контроллер наполенных бутылок. позволяет просматривать списком, добавлять
* и удалять нап.бутылки 
*/
class FilledbottlesController extends Zend_Controller_Action
{
    // маппер
    protected $filledBottles;
    
    public function init()
    {
        $this->filledBottles = new Application_Model_FilledBottlesMapper();
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
                $filledBottles->save($filledBottle);
                
                return $this->_helper->redirector('index');
            }
        }
        
        // отправляем нап.бутылку и форму в вид
        $this->view->filledBottles = $filledBottles->fetchAll();
        $this->view->form = $form;
    }


}

