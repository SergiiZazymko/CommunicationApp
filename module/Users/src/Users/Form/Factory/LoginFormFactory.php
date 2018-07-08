<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 03.07.18
 * Time: 22:42
 */

namespace Users\Form\Factory;


use Users\Form\LoginForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class LoginFormFactory
 * @package Users\Form
 */
class LoginFormFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed|LoginForm
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new LoginForm();
    }
}
