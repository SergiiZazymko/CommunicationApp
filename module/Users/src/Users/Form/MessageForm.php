<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 19.08.18
 * Time: 19:29
 */

namespace Users\Form;


use Zend\Form\Element\Text;
use Zend\Form\Form;

/**
 * Class MessageForm
 * @package Users\Form
 */
class MessageForm extends Form
{
    /**
     * MessageForm constructor.
     * @param null $name
     */
    public function __construct($name = null)
    {
        parent::__construct('MessageForm');
        $this->init();
    }

    /**
     *
     */
    public function init()
    {
        $this->add([
            'name' => 'message',
            'attributes' => [
                'type' => Text::class,
                'id' => 'messageText',
                'required' => 'required',
            ],
            'options' => [
                'label' => 'Message',
            ],
        ])
            ->add([
                'name' => 'Submit',
                'attributes' => [
                    'type' => 'submit',
                    'value' => 'Send',
                ]
            ])
            ->add([
                'name' => 'Refresh',
                'attributes' => [
                    'type' => 'button',
                    'id' => 'btnRefresh',
                    'value' => 'Refresh',
                ]
            ]);

        parent::init();
    }
}
