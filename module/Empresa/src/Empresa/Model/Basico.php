<?php

namespace Empresa\Model;

use Zend\Db\Adapter\Adapter;

use Zend\Db\Sql\Sql,
Zend\Db\Sql\Where;

use Zend\Db\TableGateway\TableGateway;

use Zend\Db\TableGateway\Feature;

class Basico extends TableGateway
{
	
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        
    }
	
	function dataToBanco($string){
		if (!empty($string))
	    return substr($string, 6, 4)."-".substr($string, 3, 2)."-".substr($string, 0, 2)." ".substr($string, 11, 8);
	}
	
	//3->Converte data do formato do banco para o formato padrão Brasil
	function datafromBanco($string){
		if (!empty($string))
	    return substr($string, 8, 2)."/".substr($string, 5, 2)."/".substr($string, 0, 4)." ".substr($string, 11, 8);
	}	

}




?>