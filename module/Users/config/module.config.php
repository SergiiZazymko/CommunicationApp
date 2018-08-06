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
                            'route' => '/[:controller[/:action]]',
                            'constraints' => [
                                'controller' => '[a-zA-Z][a-zA-Z0-9_]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_]*',
                            ],
                            'defaults' => [
                                // ...
                            ],
                        ],
                    ],
                    'user-manager' => [
                        'type' => \Zend\Mvc\Router\Http\Segment::class,
                        'options' => [
                            'route' => '/user-manager[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_]*',
                                'id' => '\d*',
                            ],
                            'defaults' => [
                                'controller' => 'Users\Controller\UserManager',
                                'action' => 'index',
                            ],
                        ],
                    ],
                ],
            ],
            'group-chat' => [
                'type' => \Zend\Mvc\Router\Http\Segment::class,
                'options' => [
                    'route' => '/group-chat[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_]*',
                        'id' => '\d*',
                    ],
                    'defaults' => [
                        'controller' => 'Users\Controller\GroupChat',
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],

    'controllers' => [
        'invokables' => [
            'Users\Controller\Index' => \Users\Controller\IndexController::class,
            'Users\Controller\Register' => \Users\Controller\RegisterController::class,
            'Users\Controller\Login' => \Users\Controller\LoginController::class,
            'Users\Controller\UserManager' => \Users\Controller\UserManagerController::class,
            'Users\Controller\GroupChat' => \Users\Controller\GroupChatController::class,
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'users' => __DIR__ . '/../view',
        ],
    ],

    'service_manager' => [
        'factories' => [
            'UserRepository' => \Users\Repository\UserRepositoryFactory::class,
            'LoginForm' => \Users\Form\Factory\LoginFormFactory::class,
            'RegisterForm' => \Users\Form\Factory\RegisterFormFactory::class,
            'AuthService' => \Users\Factory\AuthServiceFactory::class,
            'UserEditForm' => \Users\Form\Factory\UserEditFormFactory::class,
        ],
        'aliases' => [

        ],
    ],
];
