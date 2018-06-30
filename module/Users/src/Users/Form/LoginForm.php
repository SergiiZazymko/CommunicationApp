<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 30.06.18
 * Time: 8:26
 */

namespace Users\Form;


use Users\Form\Filter\LoginFilter;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;

/**
 * Class LoginForm
 * @package Users\Form
 */
class LoginForm extends Form
{
    /**
     * LoginForm constructor.
     * @param null $name
     */
    public function __construct($name = null)
    {
        parent::__construct('Login');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setInputFilter(new LoginFilter());

        /** @var Text $email */
        $email = new Text('email');
        $email->setLabel('Email');
        $this->add($email);

        /** @var Password $password */
        $password = new Password('password');
        $password->setLabel('Password');
        $this->add($password);

        /** @var Submit $submit */
        $submit = new Submit('submit');
        $submit->setValue('Submit');
        $this->add($submit);
    }
}
