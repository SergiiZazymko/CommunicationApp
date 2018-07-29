<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 08.07.18
 * Time: 18:41
 */

namespace Files\Factory;

use Files\Entity\File;
use Files\Repository\FileRepository;
use Users\StdLib\Table;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FileRepositoryFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var Adapter $adapter */
        $adapter = $serviceLocator->get('Database');

        /** @var ResultSet $resultSet */
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new File());

        /** @var TableGateway $tableGateway */
        $tableGateway = new TableGateway(
            Table::FILE,
            $adapter,
            null,
            $resultSet
        );

        $fileSharingTableGateway = new TableGateway(
            Table::FILE_SHARING,
            $adapter
        );

        return new FileRepository($tableGateway, $fileSharingTableGateway);
    }
}
