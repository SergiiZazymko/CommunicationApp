<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 29.07.18
 * Time: 16:37
 */

namespace Files\Factory;


use Files\Form\EditForm;
use Users\Repository\UserRepository;
use Zend\Db\ResultSet\ResultSet;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EditFormFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var UserRepository $userRepository */
        $userRepository = $serviceLocator->get('UserRepository');

        /** @var ResultSet $users */
        $users = $userRepository->fetchAll();

        /** @var array $options */
        $options = [];

        foreach ($users as $user) {
            $options[$user->id] = $user->name;
        }

        /** @var EditForm $editForm */
        $editForm = new EditForm();
        $editForm->get('select')->setValueOptions($options);

        return $editForm;
    }
}