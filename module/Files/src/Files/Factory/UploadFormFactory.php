<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 09.07.18
 * Time: 16:50
 */

namespace Files\Factory;


use Files\Form\UploadForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class UploadFormFactory
 * @package Files\Factory
 */
class UploadFormFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return UploadForm|mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new UploadForm();
    }
}
