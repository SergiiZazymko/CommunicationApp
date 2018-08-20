<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 20.08.18
 * Time: 21:03
 */

namespace Users\Form;


use Users\Form\Filter\EmailFilter;
use Users\Repository\UserRepository;
use Zend\Form\Element\Select;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;

/**
 * Class EmailForm
 * @package Users\Form
 */
class EmailForm extends Form
{
    /** @var array $users */
    protected $users;

    /**
     * EmailForm constructor.
     * @param string $name
     * @param UserRepository $userRepository
     */
    public function __construct($name, array $users)
    {
        $this->users = $users;
        parent::__construct($name);
        $this->init();
    }

    /**
     *
     */
    public function init()
    {
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setInputFilter(new EmailFilter);

        /** @var Select $toUser */
        $toUser = new Select('toUser');
        $toUser->setValueOptions($this->users);
        $toUser->setLabel('To');
        $this->add($toUser);

        /** @var Text $subject */
        $subject = new Text('subject');
        $subject->setLabel('Subject');
        $this->add($subject);

        /** @var Text $message */
        $message = new Textarea('message');
        $message->setLabel('Message');
        $this->add($message);

        /** @var Submit $submit */
        $submit = new Submit('submit');
        $submit->setValue('Send');
        $submit->setLabel('Send message');
        $this->add($submit);

        parent::init();
    }
}
