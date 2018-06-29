<?php

namespace Users\Form;

use Users\Form\Filter\RegisterFilter;
use Zend\Form\Element\Email;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;

/**
 * Class RegisterForm
 * @package Users\Form
 */
class RegisterForm extends Form
{
    /**
     * RegisterForm constructor.
     * @param string $name
     */
    public function __construct($name = 'Register')
    {
        parent::__construct($name);
        $this->setAttribute('methos', 'post')
            ->setAttribute('enctype', 'multipart/form-data');
        $this->setInputFilter(new RegisterFilter());

        /** @var Text $name */
        $name = new Text('name');
        $name->setLabel('Name');
        $this->add($name);

        /** @var Email $email */
        $email = new Email('email');
        $email->setLabel('Email');
        $this->add($email);

        /** @var Password $password */
        $password = new Password('password');
        $password->setLabel('Password');
        $this->add($password);

        /** @var Password $confirmPassword */
        $confirmPassword = new Password('confirmPassword');
        $confirmPassword->setLabel('Confirm password');
        $this->add($confirmPassword);

        /** @var Submit $submit */
        $submit = new Submit('submit');
        $submit->setValue('Submit');
        $this->add($submit);
    }
}
