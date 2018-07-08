<?php

namespace Users\Form;

use Users\Form\Filter\UserEditFilter;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;

/**
 * Class UserEditForm
 * @package Users\Form
 */
class UserEditForm extends Form
{
    /**
     * RegisterForm constructor.
     * @param string $name
     */
    public function __construct($name = 'UserEdit')
    {
        parent::__construct($name);
        $this->setAttribute('method', 'post')
            ->setAttribute('enctype', 'multipart/form-data');
        $this->setInputFilter(new UserEditFilter());

        /** @var Text $name */
        $name = new Text('name');
        $name->setLabel('Name');
        $this->add($name);

        /** @var Text $email */
        $email = new Text('email');
        $email->setLabel('Email');
        $this->add($email);

        /** @var Submit $submit */
        $submit = new Submit('submit');
        $submit->setValue('Submit');
        $this->add($submit);
    }
}
