<?php

namespace Users\Controller;

use Users\Form\LoginForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class LoginController
 * @package Users\Controller
 */
class LoginController extends AbstractActionController
{
    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        /** @var boolean $error */
        $error = false;
        /** @var LoginForm $form */
        $form = new LoginForm();
        if ($this->getRequest()->isPost()) {
            if ($form->setData($this->params()->fromPost())->isValid()) {
                $data = $form->getData();
                /** @var ViewModel $view */
                $view = new ViewModel([
                    'data' => $data,
                ]);
                $view->setTemplate('users/login/confirm');
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
