<?php
return [
    'router' => [
        'routes' => [
            'time' => [
                'type' => \Zend\Mvc\Router\Http\Segment::class,
                'options' => [
                    'route' => '/:controller/:action',
                    'constraints' => [
                        'controller' => '[a-zA-Z][a-zA-Z0-9_]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_]*',
                    ],
                ],
            ],
        ],
    ],

    'controllers' => [
        'invokables' => [
            'time' => \CurrentTime\Controller\TimeController::class,
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'current_time' => __DIR__ . '/../view',
        ],
    ],
];
