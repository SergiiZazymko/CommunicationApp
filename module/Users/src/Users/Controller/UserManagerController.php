<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 08.07.18
 * Time: 13:56
 */

namespace Users\Controller;


use Users\Entity\User;
use Users\Form\RegisterForm;
use Users\Form\UserEditForm;
use Users\Repository\UserRepository;
use Zend\Db\ResultSet\ResultSet;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Model\ViewModel;

/**
 * Class UserManagerController
 * @package Users\Repository
 */
class UserManagerController extends AbstractActionController
{
    /**
     * @return array|ViewModel
     */
    public function indexAction()
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->getServiceLocator()->get('UserRepository');
        /** @var ResultSet $users */
        $users = $userRepository->fetchAll();
        return new ViewModel([
            'users' => $users,
        ]);
    }

    public function createAction()
    {
        /** @var ServiceManager $serviceManager */
        $serviceManager = $this->getServiceLocator();

        /** @var UserRepository $userRepository */
        $userRepository = $serviceManager->get('UserRepository');

        /** @var RegisterForm $form */
        $form = $serviceManager->get('RegisterForm');

        /** @var User $user */
        $user = new User();

        $form->bind($user);

        if ($this->getRequest()->isPost() && ($form->setData($this->params()->fromPost()))->isValid()) {

            $userRepository->saveUser($user);

            return $this->redirect()->toRoute('users/user-manager');
        }

        return new ViewModel([
            'form' => $form,
        ]);



    }

    /**
     * @return \Zend\Http\Response|ViewModel
     * @throws \Exception
     */
    public function editAction()
    {
        /** @var UserEditForm $form */
        $form = $this->getServiceLocator()->get('UserEditForm');

        /** @var UserRepository $userRepository */
        $userRepository = $this->getServiceLocator()->get('UserRepository');

        /** @var int $id */
        $id = $this->params()->fromRoute('id');

        /** @var User $user */
        $user = $userRepository->getUser($id);

        $form->bind($user);

        if ($this->getRequest()->isPost() && ($form->setData($this->params()->fromPost()))->isValid()) {
            /** @var array $data */
            $userRepository->saveUser($user);

            return $this->redirect()->toRoute(null, [
                'controller' => 'UserManager',
                'action' => 'index',
            ]);
        }

        return new ViewModel([
            'form' => $form,
        ]);
    }

    /**
     * @return \Zend\Http\Response
     */
    public function deleteAction()
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->getServiceLocator()->get('UserRepository');

        /** @var int $id */
        $id = $this->params()->fromRoute('id');

        $userRepository->deleteUser($id);

        return $this->redirect()->toRoute(null, [
            'controller' => 'UserManager',
            'action' => 'index',
        ]);
    }
}
