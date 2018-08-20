<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 20.08.18
 * Time: 21:27
 */

namespace Users\Controller;


use Users\Entity\User;
use Zend\Authentication\AuthenticationService;
use Zend\Form\Form;
use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class EmailController
 * @package Users\Controller
 */
class EmailController extends AbstractActionController
{
    /**
     * @return bool|User
     */
    public function getLoggedUser()
    {
        /** @var AuthenticationService $authService */
        $authService = $this->getServiceLocator()->get('AuthService');
        /** @var User $loggedUser */
        $email = $authService->getStorage()->read();

        if (!$email) {
            return false;
        }

        /** @var User $user */
        $user = $this->getServiceLocator()->get('UserRepository')->getUserByEmail($email);

        return $user;
    }

    /**
     * @return array|\Zend\Http\Response|ViewModel
     */
    public function indexAction()
    {
        /** @var Form $form */
        $form = $this->serviceLocator->get('EmailForm');

        if ($this->getRequest()->isPost() && ($form->setData($this->params()->fromPost()))->isValid()) {
            /** @var string $fromEmail */
            $fromEmail = $this->getLoggedUser()->email;

            /** @var string $fromName */
            $fromName = $this->getLoggedUser()->name;

            /** @var array $data */
            $data = $form->getData();

            /** @var string $to */
            $to = $data['toUser'];

            /** @var string $subject */
            $subject = $data['subject'];

            /** @var string $body */
            $body = $data['message'];

            /** @var Message $message */
            $message = new Message;
            $message->setFrom($fromEmail, $fromName)
                ->setTo($to)
                ->setSubject($subject)
                ->setBody($body);

            /** @var Sendmail $sendmail */
            $sendmail = new Sendmail;
            $sendmail->send($message);

            return $this->redirect()->toRoute('users/email');

        }
        return new ViewModel([
            'form' => $form,
        ]);
    }
}
