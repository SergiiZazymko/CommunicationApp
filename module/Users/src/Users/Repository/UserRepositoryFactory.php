<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 03.07.18
 * Time: 22:23
 */

namespace Users\Repository;


use Users\Entity\User;
use Users\StdLib\Table;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class UserRepositoryFactory
 * @package Users\Repository
 */
class UserRepositoryFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed|UserRepository
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var Adapter $adapter */
        $adapter = $serviceLocator->get('Database');

        /** @var ResultSet $resultSet */
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new User());

        /** @var TableGateway $tableGateway */
        $tableGateway = new TableGateway(
            Table::USER,
            $adapter,
            null,
            $resultSet
        );

        /** @var UserRepository $userRepository */
        $userRepository = new UserRepository($tableGateway);
        return $userRepository;
    }
}
