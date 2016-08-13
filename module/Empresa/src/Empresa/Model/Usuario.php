<?php


namespace Empresa\Model;

use Zend\Db\Adapter\Adapter;

use Zend\Db\Sql\Sql,
Zend\Db\Sql\Where,
Zend\Db\ResultSet\ResultSet,
Empresa\Model\Basico;



use Zend\Db\TableGateway\TableGateway;

use Zend\Db\TableGateway\Feature;

 	

class Usuario extends Basico
{
	protected $cdusuario;
	protected $nmusuario;
	private $email;
	private $senha;

	
	protected $table = 'tb_usuario';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        
    }
		
	public function setNmUsuario($nmusuario){
		$this->nmusuario = $nmusuario;
	}
	
	public function getNmUsuario(){
		return $this->nmusuario;
	}
	
	public function setEmail($email){
		$this->email = $email;
	}
	
	public function getEmail(){
		return $this->email;
	}
	
	public function setSenha($senha){
		$this->senha = $senha;
	}
	
	public function getSenha(){
		return $this->senha;
	}

	public function setTodos($dados){
		$this->setNmUsuario($dados['nmusuario']);
		$this->setEmail($dados['usuario']);
		$this->setSenha(md5($dados['senha']));
	}
	
	public function getTodos(){
		$dados = array(
				'nmusuario' => $this->getNmUsuario(),
				'email' => $this->getEmail(),
				'senha' => $this->getSenha(),
				
		);
		return $dados;
	}		
	

	public function inserir($dados)
	{
		try {

			$this->setTodos($dados);
			
			$sql = new Usuario($this->adapter);
		
			$results = $sql->insert($this->getTodos());
			
			return $results;
			
		}catch(Exception $e){
    		$erro = $e->getMessage();
    	}
	}

	
	public function validaAcesso($usuario,$senha){
	
		try {
			$sql = new Sql($this->adapter);
			
			$select = $sql->select();
			$select->from(array('tu'=>$this->table))
				   ->where("tu.email = '$usuario' and tu.senha = '$senha'");
				  		   
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
	
	public function validaAmbiguo($email){
	
		try {
			$sql = new Sql($this->adapter);
			
			$select = $sql->select();
			$select->from(array('tu'=>$this->table))
				   ->where("tu.email = '$email'");
				  		   
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