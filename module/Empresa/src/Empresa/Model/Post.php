<?php


namespace Empresa\Model;

use Zend\Db\Adapter\Adapter;

use Zend\Db\Sql\Sql,
Zend\Db\Sql\Where,
Zend\Db\ResultSet\ResultSet,
Empresa\Model\Basico;

use Zend\Db\TableGateway\TableGateway;

use Zend\Db\TableGateway\Feature;

 	

class Post extends Basico
{
	protected $cdpost;
	protected $titulo;
	protected $conteudo;
	protected $cdstatus;
	protected $cdusuario;
	
	protected $table = 'tb_post';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        
    }

	public function setCodigo($cdpost){
		$this->cdpost = $cdpost;
	}
	
	public function getCodigo(){
		return $this->cdpost;
	}
		
	public function setUsuario($cdusuario){
		$this->cdusuario = $cdusuario;
	}
	
	public function getUsuario(){
		return $this->cdusuario;
	}
	
	public function setTitulo($titulo){
		$this->titulo = $titulo;
	}
	
	public function getTitulo(){
		return $this->titulo;
	}
	
	public function setConteudo($conteudo){
		$this->conteudo = $conteudo;
	}
	
	public function getConteudo(){
		return $this->conteudo;
	}
	
	public function setStatus($cdstatus){
		$this->cdstatus = $cdstatus;
	}
	
	public function getStatus(){
		return $this->cdstatus;
	}
	
	
	public function setTodos($dados){
		$this->setTitulo(strtoupper($dados['titulo']));
		$this->setConteudo($dados['conteudo']);
		$this->setStatus($dados['cdstatus']);
		$this->setUsuario($dados['cdusuario']);
	}
	
	public function getTodos(){
		$dados = array(
				'titulo' => $this->getTitulo(),
				'conteudo' => $this->getConteudo(),
				'cdstatus' => $this->getStatus(),
				'cdusuario' => $this->getUsuario(),
		
		);
		return $dados;
	}		
	
	
	public function getPostAll()
	{
		try {
			$sql = new Sql($this->adapter);
			$select = $sql->select();
			$select->from(array('tp'=>$this->table))
					->join(array('tu' => 'tb_usuario'),'tu.cdusuario = tp.cdusuario',array('cdusuario','nmusuario'))
					->order('tp.dtcriacao desc');			
					

			$selectString = $sql->getSqlStringForSqlObject($select);
			
			$results = $this->adapter->query($selectString, adapter::QUERY_MODE_EXECUTE);
	
			if(null !== $results){
				return $results;
			}
			
		}catch(Exception $e){
    		$erro = $e->getMessage();
    	}
	}
	
	public function inserir($dados)
	{
		try {

			$this->setTodos($dados);
			
			$sql = new Post($this->adapter);
			
			$dados = $this->getTodos();
			$dados['dtcriacao'] = date("Y-m-d H:i:s");    
		
			$results = $sql->insert($dados);
			
			return $results;
			
		}catch(Exception $e){
    		$erro = $e->getMessage();
    	}
	}
	
	public function buscapostid($cdpost){
	
		try {
			$sql = new Sql($this->adapter);
			
			$select = $sql->select();
			$select->from(array('tp'=>$this->table))
				   ->where("tp.cdpost = '$cdpost'");
				  		   
			$statement = $sql->prepareStatementForSqlObject($select); 
	
			$results = $statement->execute();
			
			$resultSet = new ResultSet();
			$resultSet->initialize($results);
			
			if(null !== $results)
				return $resultSet->toArray(); 
				
		}catch(Exception $e){
    		$erro = $e->getMessage();
    	}  
					   
	}
	
	public function validaambiguo($titulo){
	
		try {
			$sql = new Sql($this->adapter);
			
			$select = $sql->select();
			$select->from(array('tp'=>$this->table))
				   ->where("tp.titulo = '$titulo'");
				  		   
			$statement = $sql->prepareStatementForSqlObject($select); 
	
			$results = $statement->execute();
			
			$resultSet = new ResultSet();
			$resultSet->initialize($results);
			
			if(null !== $results)
				return $resultSet->toArray(); 
				
		}catch(Exception $e){
    		$erro = $e->getMessage();
    	}  
					   
	}
	
	

}


?>