<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * Включаем сессии (вообще говоря, используется только для флеш-сообщений)
     */
    protected function _initSession()
    {
        Zend_Session::start();
    }
    
    /**
     * Устанавливаем в лайаут доктайп, некоторые js-скрипты и форму поиска
     */
	protected function _initLayoutVars()
	{
		$this->bootstrap('view');
		$view = $this->getResource('view');
        // доктайп
		$view->doctype('XHTML1_STRICT');
        // форма поиска
        $view->searchform = new Application_Form_Search();
        // js-скрипты
        $view->headScript()->appendFile('/js/jquery.js', 'text/javascript');
        $view->headScript()->appendFile('/js/chain.js', 'text/javascript');
        $view->headScript()->appendFile('/js/script.js', 'text/javascript');
	}
    /**
     * Устанавливаем роутеры
     */
    protected function _initRoutes(){
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/routes.ini', 'production');
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();
        $router->addConfig($config, 'routes');
    }
}

