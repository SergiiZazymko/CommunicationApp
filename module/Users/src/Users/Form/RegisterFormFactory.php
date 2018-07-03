<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 03.07.18
 * Time: 22:44
 */

namespace Users\Form;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class RegisterFormFactory
 * @package Users\Form\Filter
 */
class RegisterFormFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed|RegisterForm
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new RegisterForm();
    }
}
