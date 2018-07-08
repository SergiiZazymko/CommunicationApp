<?php

namespace Users\Controller;

use Users\Entity\User;
use Users\Form\RegisterForm;
use Users\Repository\UserRepository;
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
        $form = $this->getServiceLocator()->get('RegisterForm');
        $form->get('submit')->setValue('Register');

        if ($this->getRequest()->isPost()) {
            if ($form->setData($this->params()->fromPost())->isValid()) {
                /** @var array $data */
                $data = $form->getData();
                /** @var ViewModel $view */
                $this->createUser($data);

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

    /**
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    protected function createUser(array $data)
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->getServiceLocator()->get('UserRepository');

        /** @var User $user */
        $user = new User();
        $user->exchangeArray($data);
        $userRepository->saveUser($user);

        return true;
    }
}
