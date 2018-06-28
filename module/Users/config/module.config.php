<?php
return [
    'router' => [
        'routes' => [
            'users' => [
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => [
                    'route' => '/users',
                    'defaults' => [
                        '__NAMESPACE__' => 'Users\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'default' => [
                        'type' => \Zend\Mvc\Router\Http\Segment::class,
                        'options' => [
                            'route' => '/[:contr[/:action]]',
                            'constraints' => [
                                'contr' => '[a-zA-Z][a-zA-Z0-9_]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_]*',
                            ],
                            'defaults' => [
                                // ...
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    'controllers' => [
        'invokables' => [
            'Users\Controller\Index' => \Users\Controller\IndexController::class,
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'users' => __DIR__ . '/../view',
        ],
    ],
];
