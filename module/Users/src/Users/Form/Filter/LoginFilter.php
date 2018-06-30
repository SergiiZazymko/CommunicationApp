<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 30.06.18
 * Time: 8:31
 */

namespace Users\Form\Filter;


use Zend\Filter\HtmlEntities;
use Zend\Filter\StringTrim;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator\EmailAddress;
use Zend\Validator\NotEmpty;

/**
 * Class LoginFilter
 * @package Users\Form\Filter
 */
class LoginFilter extends InputFilter
{
    /**
     * LoginFilter constructor.
     */
    public function __construct()
    {
        /** @var Input $email */
        $email = new Input('email');
        $email->getFilterChain()
            ->attach(new StringTrim())
            ->attach(new HtmlEntities());
        $email->setRequired(true)
            ->getValidatorChain()
            ->attach(new EmailAddress([
                'messages' => [
                    EmailAddress::INVALID_FORMAT => 'Invalid format of email',
                    EmailAddress::INVALID_HOSTNAME => 'Invalid hostname',
                ],
            ]));
        $this->add($email);

        /** @var Input $password */
        $password = new Input('password');
        $password->getFilterChain()
            ->attach(new StringTrim())
            ->attach(new HtmlEntities());
        $password->setRequired(true)
            ->getValidatorChain()
            ->attach(new NotEmpty());
        $this->add($password);
    }
}
