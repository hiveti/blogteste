<?php
/**
* @autor Raquel Souza Oliveira <raqueloliveiracsi@gmail.com>
* @package 
* @version 0.1
* @datecreation 12/08/2016 (Raquel Oliveira)
* @lastchangedate 12/08/2016 (Raquel Oliveira)
*/

namespace Empresa;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;


use Zend\ModuleManager\ModuleManager;
use Zend\Session\Container;


class Module
{
	
	public function init(ModuleManager $moduleManager)
    {
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
         
        $sharedEvents->attach('Zend\Mvc\Controller\AbstractActionController', MvcEvent::EVENT_DISPATCH, array($this, 'verificaAutenticacao'), 100);
    }
	
	
	public function onBootstrap(MvcEvent $e)
	{
		
		$eventManager        = $e->getApplication()->getEventManager();
		
		$moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
	  
		$eventManager->attach (MvcEvent::EVENT_ROUTE, function (MvcEvent $e) {
			$controller_loader = $e->getApplication ()->getServiceManager ()->get ('ControllerLoader');

			$controller = $e->getRouteMatch ()->getParam ('controller');
			$controller_class =  ucfirst ($controller).'Controller';

			// Add service locator to the controller
			$controller_object = new $controller_class;
			$controller_object->setServiceLocator ($e->getApplication ()->getServiceManager ());
			// ------------------------------------
			$controller_loader->setService ($controller, $controller_object);
		});

			//Fixa o layout para este modulo
			$e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e)
			{
				$controller = $e->getTarget();
				$controllerClass = get_class($controller);
				$moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
				$config = $e->getApplication()->getServiceManager()->get('config');
				if (isset($config['module_layouts'][$moduleNamespace])) {
					$controller->layout($config['module_layouts'][$moduleNamespace]);
				}
			}
			, 100);
			
	}

	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}

	public function getAutoloaderConfig()
	{
		return array(
				'Zend\Loader\StandardAutoloader' => array(
						'namespaces' => array(
								__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
						),
				),
		);
	}
	
	  
    public function verificaAutenticacao($e)
    {   
        $controller = $e->getTarget();
        $rota = $controller->getEvent()->getRouteMatch()->getMatchedRouteName();
        

        if ($rota == 'empresa/default') {
            $sessao = new Container('Auth');
			
            if (!$sessao->admin) {			
                return $controller->redirect()->toRoute('login');
            }
      
        }
    }
       
}
