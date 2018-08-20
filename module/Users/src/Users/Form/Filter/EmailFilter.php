<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 20.08.18
 * Time: 21:41
 */

namespace Users\Form\Filter;


use Zend\Filter\HtmlEntities;
use Zend\Filter\StringTrim;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator\EmailAddress;
use Zend\Validator\NotEmpty;

/**
 * Class EmailFilter
 * @package Users\Form\Filter
 */
class EmailFilter extends InputFilter
{
    /**
     * EmailFilter constructor.
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     *
     */
    public function init()
    {
        /** @var Input $toUser */
        $toUser = new Input('toUser');
        $toUser->getFilterChain()
            ->attach(new StringTrim)
            ->attach(new HtmlEntities);
        $toUser->setRequired(true)
            ->getValidatorChain()
            ->attach(new EmailAddress([
                EmailAddress::INVALID_FORMAT => 'Invalid format',
                EmailAddress::INVALID_HOSTNAME => 'Ivalid hostaname',
            ]));
        $this->add($toUser);

        /** @var Input $subject */
        $subject = new Input('subject');
        $subject->getFilterChain()
            ->attach(new StringTrim)
            ->attach(new HtmlEntities);
        $subject->setRequired(true)
            ->getValidatorChain()
            ->attach(new NotEmpty);
        $this->add($subject);

        /** @var Input $message */
        $message = new Input('message');
        $message->getFilterChain()
            ->attach(new StringTrim)
            ->attach(new HtmlEntities);
        $message->setRequired(true)
            ->getValidatorChain()
            ->attach(new NotEmpty);
        $this->add($message);

        parent::init();
    }
}
