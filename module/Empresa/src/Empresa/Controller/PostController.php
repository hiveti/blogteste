<?php


namespace Empresa\Controller;

use Empresa\Form\FormPost;

use Empresa\Model\Basico;
use Empresa\Model\Post;

use Zend\Db\Sql\Sql;

use Zend\View\Model\ViewModel;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

class PostController extends AbstractActionController
{
	
	public function indexAction()
	{

		$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

		$post = new Post($adapter);
		$result = $post->getPostAll();
		
		return new ViewModel(array(
								'rowset' => $result,
								'adapter' => $adapter,
							));
	
	}

	public function cadastrarAction()
	{
		
		$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');	
		$sessao = new Container('mensagempost');
		$sessaousuario = new Container('Auth');

		$form = new FormPost($adapter);
		$request = $this->getRequest();
		
		
		if($request->isPost())
		{
			$post = new Post($adapter);

			$form->setData($request->getPost());
			
			//Validação do Formulário
			if($form->isValid())
			{			
				$data = $form->getData();

				$data['titulo'] = strtoupper($data['titulo']);		
				$dados = $post->validaambiguo($data['titulo']);
				
				$data['cdusuario'] = $sessaousuario->cdusuario;
				
				if(count($dados[0]) > 0){
					$sessao->mensagem = "Já existe um post cadastrado com este mesmo título, por favor crie outro!";			
					$this->redirect()->toUrl('/empresa/post');	
				}else{
					if($post->inserir($data)){
						$sessao->mensagem = "Post Cadastrado Com Sucesso!";			
						$this->redirect()->toUrl('/empresa/post');
					}
				}
			}
		 }
		
		$view = new ViewModel(array(
			'form' => $form,
		));
	
		$view->setTemplate('empresa/post/form.phtml');

		return $view;
	}

	public function alterarAction()
	{
		
		$cdpost = (int) $this->params('id');
		
		$sessaousuario = new Container('Auth');
			
		$sessao = new Container('mensagempost');
		$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');		
		
		$post = new Post($adapter);
		$modelbasico = new Basico($adapter);
		
		$form = new FormPost($adapter);
		$request = $this->getRequest();
			
		$dados = $post->buscapostid($cdpost);
	
		$form->setData($dados[0]);
		
		if($request->isPost())
		{	
			if($form->isValid())
			{
				$data = $_POST;
				$data['cdusuario'] = $sessaousuario->cdusuario;

				$post->setTodos($data);
				$dadospost =  $post->getTodos();
				
				$dados = $post->validaambiguo($dadospost['titulo']);
				
				if(count($dados[0]) > 0 && $dados[0]['titulo'] != $dadospost['titulo']){
					$sessao->mensagem = "Já existe um post cadastrado com este mesmo título, por favor crie outro!";			
					$this->redirect()->toUrl('/empresa/post');	
				}else{		
					if($post->update($dadospost,array('cdpost'=>$cdpost)))
					{
						$sessao->mensagem = "Post Alterado Com Sucesso!";
						return $this->redirect()->toUrl('/empresa/post');
					}
				}
			}
		}


		$view = new ViewModel(array(
			'form' => $form,
		));

		$view->setTemplate('empresa/post/form.phtml');

		return $view;
	}

	public function excluirAction()
	{	
		//Inicializa a Sessão
		$sessao = new Container('mensagempost');
		
		$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');		
		$post = new Post($adapter);
		
		$cdpost = $_POST['cdpost'];
		
		if($post->delete(array('cdpost'=>$cdpost)))
		{	
			$sessao->mensagem = "Post Excluido Com Sucesso!";
			
			die();
		}	
	}
	
	public function visualizarAction()
	{
		
		$cdpost = (int) $this->params('id');
			
		$sessao = new Container('mensagempost');
		$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');		
		
		$post = new Post($adapter);
		$modelbasico = new Basico($adapter);
		
		$form = new FormPost($adapter);
		$request = $this->getRequest();
		
		//Habilita campos para inserir no banco.
		$form->get("titulo")->setAttribute('disabled',true);	
		$form->get("conteudo")->setAttribute('disabled',true);	
		$form->get("cdstatus")->setAttribute('disabled',true);	
		$form->get("salvar")->setAttribute('disabled',true);	
		

		$dados = $post->buscapostid($cdpost);
	
		$form->setData($dados[0]);
		

		$view = new ViewModel(array(
			'form' => $form,
		));

		$view->setTemplate('empresa/post/form.phtml');

		return $view;
	}
	
	/**
	* CARREGA SOMENTE OS DADOS DA TABELA
	*/
	public function tablepostAction(){	
		
		$this->layout('layout/empty');
		
		$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		$sessaousuario = new Container('Auth');
		
		$post = new Post($adapter);
		$modelbasico = new Basico($adapter);
		
		$result = $post->getPostAll();

		$cdpost = $_POST['cdpost'];
		
		if(count($result) > 0){
		
			foreach ($result as $post): 
					
				if($post['cdusuario'] == $sessaousuario->cdusuario){
					$class = '"fa fa-pencil-square-o"';
					$par = 'alterar/';
				}else{
					$class = '"fa fa-search" aria-hidden="true"';
					$par = 'visualizar/';
				}
				ECHO $class;
				
				 echo
					"<tr>
						<td>".$post['cdpost']."</td>
						<td>".$post['titulo']."</td>				
						<td>".$post['nmusuario']."</td>
						";
						if(empty($post['dtalteracao'])){
						 	echo "<td>".$modelbasico->datafromBanco($post['dtcriacao'])."</td>";
					  	}else{
					  	 	echo "<td>".$modelbasico->datafromBanco($post['dtalteracao'])."</td>";
					  	 }
					  	echo
						"<td>
							<a href='/empresa/post/".$par.$post['cdpost']."' title='EDITAR'><i class=$class></i></a>";
							if($post['cdusuario'] == $sessaousuario->cdusuario){
								echo "<a onclick='excluirPost(\"".$post['cdpost']."\")' style='cursor: pointer'><i class='fa fa-times'></i></a>";
							}
							echo
						"</td>
					</tr>";
			
			endforeach;
		}

		die();
	}
	
	public function appearmensagemAction(){
		$this->layout('layout/empty');
		
		$sessao = new Container('mensagempost');
		
		if($sessao->mensagem != null){
			echo 
			"<div id='mensagem-alert' class='alert btn-success text-center' role='alert'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>".$sessao->mensagem."
			</div>";
		}
			
		die();	
	}
	
}

?>