<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initLayoutVars()
	{
		$this->bootstrap('view');
		$view = $this->getResource('view');
        
		$view->doctype('XHTML1_STRICT');
        $view->searchform = new Application_Form_Search();
        $view->headScript()->appendFile('/js/jquery.js', 'text/javascript');
        $view->headScript()->appendFile('/js/chain.js', 'text/javascript');
        $view->headScript()->appendFile('/js/script.js', 'text/javascript');
	}
    
    protected function _initRoutes(){
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/routes.ini', 'production');
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();
        $router->addConfig($config, 'routes');
    }
}

