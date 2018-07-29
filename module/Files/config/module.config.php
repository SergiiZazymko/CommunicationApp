<?php
return [
    'router' => [
        'routes' => [
            'files' => [
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => [
                    'route' => '/files',
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'file-manager' => [
                        'type' => \Zend\Mvc\Router\Http\Segment::class,
                        'options' => [
                            'route' => '[/file-manager[/:action][/:id][/:userId]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_]*',
                                'id' => '\d*',
                                'userId' => '\d*',
                            ],
                            'defaults' => [
                                'controller' => 'Files\Controller\FileManager',
                                'actoon' => 'index',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    'controllers' => [
        'invokables' => [
            \Files\Controller\FileManagerController::class => \Files\Controller\FileManagerController::class,
        ],
        'aliases' => [
            'Files\Controller\FileManager' => \Files\Controller\FileManagerController::class,
        ]
    ],

    'view_manager' => [
        'template_path_stack' => [
            'files' => __DIR__ . '/../view',
        ],
    ],

    'service_manager' => [
        'factories' => [
            \Files\Repository\FileRepository::class => \Files\Factory\FileRepositoryFactory::class,
            \Files\Form\UploadForm::class => \Files\Factory\UploadFormFactory::class,
            \Files\Form\EditForm::class => \Files\Factory\EditFormFactory::class,
        ],
        'aliases' => [
            'FileRepository' => \Files\Repository\FileRepository::class,
            'UploadForm' => \Files\Form\UploadForm::class,
            'EditForm' => \Files\Form\EditForm::class,
        ]
    ],

    'module_config' => [
        'upload_location' => './data/uploads',
    ],
];
