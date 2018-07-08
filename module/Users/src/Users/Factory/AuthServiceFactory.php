<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 07.07.18
 * Time: 16:12
 */

namespace Users\Factory;


use Zend\Authentication\Adapter\DbTable;
use Zend\Authentication\AuthenticationService;
use Zend\Db\Adapter\Adapter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class AuthServiceFactory
 * @package Users\Factory
 */
class AuthServiceFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed|AuthenticationService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var Adapter $adapter */
        $adapter = $serviceLocator->get('Database');
        /** @var DbTable $authAdapter */
        $authAdapter = new DbTable(
            $adapter,
            'user',
            'email',
            'password',
            'MD5(?)'
        );
        /** @var AuthenticationService $authService */
        $authService = new AuthenticationService();
        $authService->setAdapter($authAdapter);
        return $authService;
    }
}
