<?php

namespace Empresa\Controller;

use Empresa\Model\Usuario;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;


class LoginController extends AbstractActionController
{
	
    public function indexAction()
    {	

		 $view =  new ViewModel();
		 return $view->setTerminal(true);
    }
    
	public function cadastrarAction()
	{
		
		$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');	
		$sessao = new Container('mensagemlogin');

		$request = $this->getRequest();
		
		if($request->isPost())
		{
			$usuario = new Usuario($adapter);

			$dados = $usuario->validaAmbiguo($_POST['usuario']);
			
			if(count($dados[0]) > 0){		
				$sessao->mensagem = "Já existe um usuario com este e-mail em nosso sistema, por favor crie outro!";			
				$this->redirect()->toUrl('/empresa/login');	
			}else{
				if($usuario->inserir($_POST)){
					$sessao->mensagem = "Post Cadastrado Com Sucesso!";			
					$this->redirect()->toUrl('/empresa/');
				}
			}
			
		 }

	}
    
    
     
}
