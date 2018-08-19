<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 19.08.18
 * Time: 14:13
 */

namespace Users\Repository;


use Users\Entity\Message;
use Users\StdLib\Table;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MessageRepositoryFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var AdapterInterface $adapter */
        $adapter = $serviceLocator->get('Database');

        /** @var ResultSet $resultSet */
        $resultSet = new ResultSet;
        $resultSet->setArrayObjectPrototype(new Message);

        /** @var TableGateway $tableGateway */
        $tableGateway = new TableGateway(
            Table::CHAT_MESSAGES,
            $adapter,
            null,
            $resultSet
        );

        return new MessageRepository($tableGateway);
    }
}
