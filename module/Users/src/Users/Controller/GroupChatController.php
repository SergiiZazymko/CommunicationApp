<?php

namespace Users\Controller;

use Users\Entity\User;
use Users\Form\MessageForm;
use Users\Repository\MessageRepository;
use Users\Repository\UserRepository;
use Zend\Authentication\AuthenticationService;
use Zend\Db\ResultSet\ResultSet;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Model\ViewModel;

/**
 * Class GroupChatController
 * @package Users\Controller
 */
class GroupChatController extends AbstractActionController
{
    /**
     * @return array|ViewModel
     */
    public function indexAction()
    {
        /** @var User $user */
        $user = $this->getLoggedUser();

        if (!$user) {
            return $this->redirect()->toRoute('users', [
                'action' => 'login',
            ]);
        }

        /** @var Request $request */
        $request = $this->getRequest();

        if ($request->isPost()) {

            /** @var string $message */
            $message = $request->getPost()->get('message');

            /** @var int $userId */
            $userId = $user->id;

            $this->sendMessage($message, $userId);

            return $this->redirect()->toRoute('users/group-chat');
        }

        $form = new MessageForm;

        return new ViewModel([
            'form' => $form,
            'userName' => $user->name,
        ]);
    }

    /**
     * @return ViewModel
     * @throws \Exception
     */
    public function messageListAction()
    {
        /** @var ServiceManager $sm */
        $sm = $this->getServiceLocator();

        /** @var UserRepository $userRepository */
        $userRepository = $sm->get('UserRepository');

        /** @var MessageRepository $messagesRepository */
        $messagesRepository = $sm->get('MessagesRepository');

        /** @var ResultSet $messages */
        $messages = $messagesRepository->fetchAll();

        /** @var array $messageList */
        $messageList = [];

        foreach ($messages as $message) {

            /** @var User $fromUser */
            $fromUser = $userRepository->getUser($message->user_id);

            /** @var array $messageData */
            $messageData = [];

            $messageData['user'] = $fromUser->name;
            $messageData['time'] = $message->time;
            $messageData['message'] = $message->message;
            $messageList[] = $messageData;
        }

        /** @var ViewModel $viewModel */
        $viewModel = new ViewModel([
            'messageList' => $messageList,
        ]);
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    /**
     * @param $messageText
     * @param $userId
     * @return int
     */
    protected function sendMessage($messageText, $userId)
    {
        /** @var MessageRepository $messagesRepository */
        $messagesRepository = $this->serviceLocator->get('MessagesRepository');

        /** @var array $data */
        $data = [
            'user_id' => $userId,
            'message' => $messageText,
        ];

        return $messagesRepository->saveMessage($data);
    }

    /**
     * @return bool
     */
    protected function getLoggedUser()
    {
        /** @var AuthenticationService $authService */
        $authService = $this->getServiceLocator()->get('AuthService');

        /** @var string $email */
        $email = $authService->getStorage()->read();

        if ($email) {
            return $this->getServiceLocator()->get('UserRepository')->getUserByEmail($email);
        }
        return false;
    }
}
