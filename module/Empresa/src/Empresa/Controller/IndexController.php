<?php

namespace Empresa\Controller;


use Empresa\Model\Usuario;
use Zend\Db\Sql\Sql;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;


class IndexController extends AbstractActionController
{
	
    public function indexAction()
    {	
    	$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
    	$modelusuario = new Usuario($adapter);
    	
    	$request = $this->getRequest();
    	  	 
		 if($request->isPost()) {
            $dadosForm = $request->getPost()->toArray();

            $autentica = $modelusuario->validaAcesso($dadosForm['usuario'],md5($dadosForm['senha']));
    
            if (count($autentica[0]) > 0) {
                $sessao = new Container('Auth');
                $sessao->admin = true;
                $sessao->cdusuario = $autentica[0]['cdusuario'];
                $sessao->nmusuario = $autentica[0]['nmusuario'];
                $this->redirect()->toUrl('/empresa/principal');
            } else {
               return $this->redirect()->toRoute('empresa/default', array('action' => 'acesso-negado'));
            }
        }
 
		 $view =  new ViewModel();
		 return $view->setTerminal(true);
	
    }
    
    public function loginAction()
    {
    	return $this->redirect()->toUrl('/empresa/login');
    		
    }
    
}
