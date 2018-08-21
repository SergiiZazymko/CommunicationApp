<?php
namespace Users;

use Zend\EventManager\EventManager;
use Zend\EventManager\SharedEventManager;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

/**
 * Class Module
 * @package Users
 */
class Module
{
    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }

    /**
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        /** @var EventManager $eventManager */
        $eventManager = $e->getApplication()->getEventManager();

        /** @var ModuleRouteListener $moduleRoutListener */
        $moduleRoutListener = new ModuleRouteListener;
        $moduleRoutListener->attach($eventManager);

        /** @var SharedEventManager $sharedEventManager */
        $sharedEventManager = $eventManager->getSharedManager();

        $sharedEventManager->attach(
            __NAMESPACE__,
            MvcEvent::EVENT_DISPATCH,
            function ($e) {
                $controller = $e->getTarget();
                var_dump($controller);
                $controllerName = $controller->getEvent()->getRouteMatch()->getParam('controller');
                if (in_array($controllerName, ['Users\\Controller\\Login'])) {
                    $controller->layout('layout/mylayout');
                }
            }
        );
    }
}
