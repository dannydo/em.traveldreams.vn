<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Dictionary\Controller\Index' => 'Dictionary\Controller\IndexController',
        ),
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'dictionary' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/dictionary',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dictionary\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'index' => __DIR__ . '/../view',
        ),
    ),
);