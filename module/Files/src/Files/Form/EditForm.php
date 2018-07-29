<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 29.07.18
 * Time: 16:30
 */

namespace Files\Form;


use Zend\Form\Element\Select;
use Zend\Form\Element\Submit;
use Zend\Form\Form;

/**
 * Class EditForm
 * @package Files\Form
 */
class EditForm extends Form
{
    /**
     * EditForm constructor.
     * @param string $name
     */
    public function __construct($name = 'Edit')
    {
        parent::__construct($name);
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->init();
    }

    /**
     *
     */
    public function init()
    {
        /** @var Select $users */
        $users = new Select('select');
        $users->setLabel('ChooseUser');
        $this->add($users);

        /** @var Submit $submit */
        $submit = new Submit('submit');
        $submit->setValue('Add user');
        $this->add($submit);
    }
}