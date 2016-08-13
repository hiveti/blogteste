<?php

namespace Empresa\Model;

use Zend\Db\Adapter\Adapter,
	Empresa\Model\Basico,
	Zend\Db\Sql\Sql,
	Zend\Db\Sql\Where;
	
use Zend\Db\TableGateway\TableGateway;

use Zend\Db\TableGateway\Feature;

 
class Status extends Basico
{
	
	protected $cdstatus;
	protected $nmstatus;

	protected $table = 'tb_status';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        
    }
   
	public function getStatus()
	{
	    return $this->cdstatus;
	}
	
	public function setStatus($cdstatus)
	{
	    $this->cdstatus = $cdstatus;
	}
    
    
	public function getNmstatus()
	{
	    return $this->nmstatus;
	}
	
	public function setNmStatus($nmstatus)
	{
	    $this->nmstatus = $nmstatus;
	}

	
	public function setDtNascimento($dtnascimento)
	{
		if(strripos($dtnascimento, '-')){
			$dtnascimento = self::datafromBanco($dtnascimento);			
		}
		else {
			$dtnascimento = self::dataToBanco($dtnascimento);
		}
		
	    $this->dtnascimento = $dtnascimento;
	}

	
	public function setTodos($dados){
		$this->setStatus($dados['cdstatus']);
		$this->setNmStatus($dados['nmstatus']);
	}
	
	public function getTodos(){
		$dados = array(
				'cdstatus' => $this->getStatus(),
				'nmstatus' => $this->getNmStatus(),
		);
		return $dados;
	}		
	



	public function buscaStatusAll()
	{
		try {
			$sql = new Sql($this->adapter);
			$select = $sql->select();
			$select->from(array("ts"=>$this->table));
			
			$selectString = $sql->getSqlStringForSqlObject($select);
	
			$result = $this->adapter->query($selectString, adapter::QUERY_MODE_EXECUTE);
			
			$selectData = array();
			
			$selectData[''] = "Selecione";  
			foreach ($result as $res) {
	            $selectData[$res['cdstatus']] = $res['nmstatus'];         
	        }
			
			if(!empty($selectData)){
				return $selectData;
			}
			
		}catch(Exception $e){
    		$erro = $e->getMessage();
    	}
	}
	



	
}


?>