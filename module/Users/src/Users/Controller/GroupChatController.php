<?php

namespace Users\Controller;

use Users\Entity\User;
use Users\Repository\MessageRepository;
use Users\Repository\UserRepository;
use Zend\Db\ResultSet\ResultSet;
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
        return new ViewModel;
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
            $fromUser = $userRepository->getUser($message->id);
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
}
