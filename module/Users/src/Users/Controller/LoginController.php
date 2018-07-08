<?php

namespace Users\Controller;

use Users\Form\LoginForm;
use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class LoginController
 * @package Users\Controller
 */
class LoginController extends AbstractActionController
{
    /** @var AuthenticationService|null $authService */
    protected $authService;

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        /** @var boolean $error */
        $error = false;
        /** @var LoginForm $form */
        $form = $this->getServiceLocator()->get('LoginForm');
        if ($this->getRequest()->isPost()) {
            if ($form->setData($this->params()->fromPost())->isValid()) {
                $this->getAuthService()->getAdapter()
                    ->setIdentity($this->request->getPost('email'))
                    ->setCredential($this->request->getPost('password'));
                $result = $this->getAuthService()->authenticate();
                if ($result->isValid()) {
                    $this->getAuthService()->getStorage()->write($this->request->getPost('email'));
                    return $this->redirect()->toRoute(null, [
                        'controller' => 'login',
                        'action' => 'confirm',
                    ]);
                }

            } else {
                $error = true;
            }
        }
        return new ViewModel([
            'error' => $error,
            'form' => $form,
        ]);
    }

    /**
     * @return ViewModel
     */
    public function confirmAction()
    {
        /** @var string $email */
        $email = $this->getAuthService()->getStorage()->read();
        return new ViewModel(['email' => $email]);
    }

    /**
     * @return null|AuthenticationService
     */
    protected function getAuthService()
    {
        if (! $this->authService) {
            /** @var AuthenticationService $authService */
            $authService = $this->getServiceLocator()->get('AuthService');
            $this->authService = $authService;
        }
        return $this->authService;
    }
}
