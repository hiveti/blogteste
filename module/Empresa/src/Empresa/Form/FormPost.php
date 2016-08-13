<?php

namespace Empresa\Form;

use Zend\Form\Element\Submit,
	Zend\Form\Element\Email,
	Zend\Form\Element\Text,
	Zend\Form\Element\Textarea,
	Zend\Form\Element\Select,
	Zend\Form\Element\Hidden,
    Empresa\Model\Status,
	Zend\Form\Form;
	
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Adapter;

class FormPost extends Form
{
	protected $adapter;
	
	public function __construct(AdapterInterface $dbAdapter)
	{
		$this->adapter = $dbAdapter;
		parent::__construct('FormPost');
		
		$titulo = new Text('titulo');
		$titulo->setLabel('Titulo*')
					 ->setAttributes(array(
					    'class'  => 'form-control',
					    'id' => 'titulo',
					    'required' => true,
					   ));	
					    							    

		$conteudo = new TextArea('conteudo');
		$conteudo->setLabel('Conteudo*')
		->setAttributes(array(
					    'class'  => 'form-control',
					    'id' => 'conteudo'
					    ));

		$modelstatus = new Status($this->adapter);			    
		$status = new Select('cdstatus');
		$status->setLabel('Status*')
				->setAttributes(array(
					    'class'  => 'form-control',
					    'id'    => 'cdstatus',
					    'required' => true
					    ))	  			   
				->setValueOptions(
						 $modelstatus->buscaStatusAll()  
				);

		$submit = new Submit('salvar');
		$submit->setAttributes(array(
			'class' => 'btn btn-primary',
			'value' => 'SALVAR')); 

		$voltar =  new Submit('voltar');
		$voltar->setAttributes(array(
			'class' => 'btn btn-danger',
			'type' => 'button',
			'value' => 'VOLTAR',
			'onclick' => "document.location.href  = '/empresa/post'", ));
		
		

		//$this->addElements(array());
		
	$this->add($titulo);
	$this->add($conteudo);
	$this->add($status);
	$this->add($submit);
	$this->add($voltar);

	}
}





?>