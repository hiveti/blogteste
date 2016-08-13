<?php

/**
 * LICENSE
 *
 * Copyright (c) 2013, Jaime Marcelo Valasek / ZF2 Tutoriais Brasil
 * http://www.zf2.com.br / http://www.valasek.com.br
 * All rights reserved.

 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:

 *  * Redistributions of source code must retain the above copyright notice, this
 *    list of conditions and the following disclaimer.

 *  * Redistributions in binary form must reproduce the above copyright notice, this
 *    list of conditions and the following disclaimer in the documentation and/or
 *    other materials provided with the distribution.

 *  * Neither the name of the {organization} nor the names of its
 *    contributors may be used to endorse or promote products derived from
 *    this software without specific prior written permission.

 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @package JVBase
 * @author Jaime Marcelo Valasek! <jaime.valasek@gmail.com>
 * @copyright Copyright (c) 2013-2013 Jaime Marcelo Valasek.
 * @link http://www.valasek.com.br / http://www.zf2.com.br
 */

namespace JVBase;

use Admin\Model\Contatos;


use Zend\ModuleManager\Feature\AutoloaderProviderInterface;

class Module implements AutoloaderProviderInterface
{
	public function getAutoloaderConfig() {
		return array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/', __NAMESPACE__)
				)
			)
		);
	}
	
	public function getConfig()
	{
	    return include __DIR__ . '/config/module.config.php';
	}
	
	public function getServiceConfig()
	{
		
		/*return array(
				'factories' => array(
						'Admin\Model\Contatos' =>  function($sm) {
							$tableGateway = $sm->get('ContatosTableGateway');
							$table = new Contatos($tableGateway);
							return $table;
						},
						'ContatosTableGateway' => function ($sm) {
							$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype(new Contatos());
							return new TableGateway('tbl_contatos', $dbAdapter, null, $resultSetPrototype);
						},
				),
		);*/
		
		
		return array(
			'invokables' => array(
				'jvbase_service_ready' => 'JVBase\Service\Ready',
				'jvbase_mapper_ready' => 'JVBase\Mapper\Ready',
				
				'jvbase_filter_token' => 'JVBase\Filter\Token',
				'jvbase_filter_basedate' => 'JVBase\Filter\Date',
				'jvbase_filter_string' => 'JVBase\Filter\String',
			),
			'initializers' => array(
			    'JVBase\Factory\InitializerDb'
			),
		);
	}
	
}