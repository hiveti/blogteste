<?php

namespace Empresa\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Session\Container;

class PrincipalController extends AbstractActionController
{
	
    public function indexAction()
    {
		 $view = new ViewModel();
		 return $view;
	
    } 
    
	public function sairAction()
    {

        $sessao = new Container;
        $sessao->getManager()->getStorage()->clear();
        return $this->redirect()->toRoute('empresa');
    } 
    
}
