<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 20.08.18
 * Time: 21:15
 */

namespace Users\Form\Factory;


use Users\Form\EmailForm;
use Users\Repository\UserRepository;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EmailFormFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var UserRepository $repository */
        $repository = $serviceLocator->get('UserRepository');
        $resultSet = $repository->fetchAll();

        $users = [];

        foreach ($resultSet as $row) {
            $users[$row->email] = $row->email;
        }

        $form = new EmailForm('EmailForm', $users);
        return $form;
    }
}
