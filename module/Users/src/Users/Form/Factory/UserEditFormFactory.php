<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 03.07.18
 * Time: 22:44
 */

namespace Users\Form\Factory;


use Users\Form\UserEditForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class UserEditFormFactory
 * @package Users\Form\Factory
 */
class UserEditFormFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed|UserEditForm
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new UserEditForm();
    }
}
