<?php

namespace Users\Controller;

use Users\Form\LoginForm;
use Zend\Authentication\Adapter\DbTable;
use Zend\Authentication\AuthenticationService;
use Zend\Db\Adapter\Adapter;
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

    public function confirmAction()
    {
        $email = $this->getAuthService()->getStorage()->read();
        return new ViewModel(['email' => $email]);
    }

    /**
     * @return null|AuthenticationService
     */
    protected function getAuthService()
    {
        if (! $this->authService) {
            /** @var Adapter $dbAdapter */
            $dbAdapter = $this->getServiceLocator()->get('Database');
            /** @var DbTable $dbTableAuthAdapter */
            $dbTableAuthAdapter = new DbTable(
                $dbAdapter,
                'user',
                'email',
                'password',
                'MD5(?)');

            /** @var AuthenticationService $authService */
            $authService = new AuthenticationService();
            $authService->setAdapter($dbTableAuthAdapter);
            $this->authService = $authService;
        }
        return $this->authService;
    }
}
