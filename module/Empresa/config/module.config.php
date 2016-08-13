<?php

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(                  
                        'controller' => 'Empresa\Controller\Index',  
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action][/:id]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            	'__NAMESPACE__' => 'Empresa\Controller'
                            ),
                        ),
                    ),
                ),
            ),
            
			
    		'empresa' => array(
    				'type'    => 'Literal',
    				'options' => array(
    						'route'    => '/empresa',
    						'defaults' => array(
    								'__NAMESPACE__' => 'Empresa\Controller',
    								'controller'    => 'Index',
    								'action'        => 'index',
    						),
    				),
    				'may_terminate' => true,
    				'child_routes' => array(
    						'default' => array(
    								'type'    => 'Segment',
    								'options' => array(
    										'route'    => '/[:controller[/:action][/:id]]',
    										'constraints' => array(
    												'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
    												'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
    										),
    										'defaults' => array(
    												'__NAMESPACE__' => 'Empresa\Controller'
    										),
    								),
    						),
    				),

    		),
    		
				'login' => array(
				    'type' => 'Literal',
				        'options' => array(
				            'route'    => '/login',
				            'defaults' => array(
				            'controller' => 'Empresa\Controller\Login',
				            'action'     => 'index',
				         ),
				     ),
				     'may_terminate' => true,
				     'child_routes' => array(
				         'default' => array(
				             'type'    => 'Segment',
				             'options' => array(
				                  'route'    => '[/:action]',
				                  'constraints' => array(
				                       'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
				                       'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
				                   ),
				                   'defaults' => array(),
				             ),
				         ),
				     ),
				 ),


            
            
            
        ),
    ),	
    'controllers' => array(
        'invokables' => array(
            'Empresa\Controller\Index' => 'Empresa\Controller\IndexController',
            'Empresa\Controller\Login' => 'Empresa\Controller\LoginController'
        ),
    ),
		
		
	'module_layouts' => array(
			'Empresa' => 'layout/empresa',
	),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/empresa.phtml',
            'empresa/index/index' => __DIR__ . '/../view/empresa/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
