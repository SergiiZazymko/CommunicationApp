<?php

namespace Users\Form\Filter;

use Zend\Filter\HtmlEntities;
use Zend\Filter\StringTrim;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator\EmailAddress;
use Zend\Validator\Identical;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;

/**
 * Class UserEditFilter
 * @package Users\Form\Filter
 */
class UserEditFilter extends InputFilter
{
    /**
     * RegisterFilter constructor.
     */
    public function __construct()
    {
        /** @var Input $name */
        $name = new Input('name');
        $name->setRequired(true)
            ->getFilterChain()
            ->attach(new StringTrim())
            ->attach(new HtmlEntities());
        $name->getValidatorChain()
            ->attach(new NotEmpty())
            ->attach(new StringLength([
                'encoding' => 'UTF-8',
                'min' => 2,
                'max' => 50,
            ]));
        $this->add($name);

        /** @var Input $email */
        $email = new Input('email');
        $email->setRequired(true)
            ->getFilterChain()
            ->attach(new StringTrim())
            ->attach(new HtmlEntities());
        $email->getValidatorChain()
            ->attach(new EmailAddress([
                'messages' => [
                    EmailAddress::INVALID_FORMAT => 'Oops! Invalid format of email',
                    EmailAddress::INVALID_HOSTNAME => 'Oops! invalid hostname',
                ]
            ]));
        $this->add($email);
    }
}
