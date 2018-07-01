<?php

namespace Users\Controller;

use Users\Entity\User;
use Users\Form\RegisterForm;
use Users\Repository\UserRepository;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
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
        /** @var Adapter $adapter */
        $adapter = $this->getServiceLocator()->get('Database');

        /** @var ResultSet $resultSetPrototype */
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new User());

        /** @var TableGateway $tableGateway */
        $tableGateway = new TableGateway('user', $adapter, null, $resultSetPrototype);

        /** @var UserRepository $userRepository */
        $userRepository = new UserRepository($tableGateway);

        /** @var User $user */
        $user = new User();
        $user->exchangeArray($data);
        $userRepository->saveUser($user);

        return true;
    }
}
