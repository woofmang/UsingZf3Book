<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Regex;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Application\Route\StaticRoute;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'about' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/about',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'about',
                    ],
                ],
            ],
            'partial-demo' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/partial-demo',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'partialDemo',
                    ],
                ],
            ],
            'getJson' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/getJson',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'getJson',
                    ],
                ],
            ],
            'barcode' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/barcode[/:type/:label]',
                    'constraints' => [
                        'type' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'label' => '[a-zA-Z0-9_-]*'
                    ],
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'barcode',
                    ],
                ],
            ],
            'doc' => [
                'type' => Regex::class,
                'options' => [
                    'regex'    => '/doc(?<page>\/[a-zA-Z0-9_\-]+)\.html',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'doc',
                    ],
                    'spec'=>'/doc/%page%.html'
                ],
            ],
            'static' => [
                'type' => StaticRoute::class,
                'options' => [
                    'dir_name'         => __DIR__ . '/../view',
                    'template_prefix'  => 'application/index/static',
                    'filename_pattern' => '/[a-z0-9_\-]+/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'static',
                    ],
                ],
            ],
            'download' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/download[/:action]',
                    'defaults' => [
                        'controller'    => Controller\DownloadController::class,
                        'action'        => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            Controller\DownloadController::class => InvokableFactory::class
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
];
