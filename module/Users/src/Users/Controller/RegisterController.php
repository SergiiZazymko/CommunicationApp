<?php

namespace Users\Controller;

use Users\Form\RegisterForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class RegisterController
 * @package Users\Controller
 */
class RegisterController extends AbstractActionController
{
    /**
     * @return array|ViewModel
     */
    public function indexAction()
    {
        /** @var boolean $error */
        $error = false;
        /** @var RegisterForm $form */
        $form = new RegisterForm();

        if ($this->getRequest()->isPost()) {
            if ($form->setData($this->params()->fromPost())->isValid()) {
                /** @var array $data */
                $data = $form->getData();
                /** @var ViewModel $view */
                $view = new ViewModel([
                    'data' => $data,
                ]);
                $view->setTemplate('users/register/confirm');
                return $view;
            } else {
                $error = true;
            }
        }
        return new ViewModel([
            'error' => $error,
            'form' => $form,
        ]);
    }
}
