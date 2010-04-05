<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initLayoutVars()
	{
		$this->bootstrap('view');
		$view = $this->getResource('view');
        
		$view->doctype('XHTML1_STRICT');
        $view->searchform = new Application_Form_Search();
	}
    
    protected function _initRoutes()
    {
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();
        
        $router->addRoute('bottles',
                            new Zend_Controller_Router_Route('bottles/:bottleId',
                                                                array(
                                                                   'controller' => 'bottles',
                                                                   'action' => 'view'
                                                                )
                                                            )
        );
        
        $router->addRoute('beverages',
                          new Zend_Controller_Router_Route('beverages/:beverageId',
                                                                array(
                                                                    'controller' => 'beverages',
                                                                    'action' => 'view'
                                                                )
                                                            )
        );
        
        $router->addRoute('editbeverages',
                          new Zend_Controller_Router_Route('beverages/edit/:beverageId',
                                                                array(
                                                                    'controller' => 'beverages',
                                                                    'action' => 'edit'
                                                                )
                                                            )
        );
        
    }
}

