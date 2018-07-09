<?php

namespace Files\Controller;

use Files\Entity\File;
use Files\Form\UploadForm;
use Files\Repository\FileRepository;
use Users\Entity\User;
use Users\Repository\UserRepository;
use Zend\Db\ResultSet\ResultSet;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Model\ViewModel;

class FileManagerController extends AbstractActionController
{

    public function indexAction()
    {
        /** @var ServiceManager $sm */
        $sm = $this->getServiceLocator();

        /** @var UserRepository $userRepository */
        $userRepository = $sm->get('UserRepository');

        /** @var FileRepository $fileRepository */
        $fileRepository = $sm->get('FileRepository');

        /** @var string $userEmail */
        $userEmail = $sm->get('AuthService')->getStorage()->read();

        /** @var User $user */
        $user = $userRepository->getUserByEmail($userEmail);

        /** @var ResultSet $rowset */
        $rowset = $fileRepository->getUploadsByUserId($user->id);

        return new ViewModel([
            'files' => $rowset,
            'email' => $userEmail,
        ]);
    }

    /**
     * @return ViewModel
     */
    public function uploadAction()
    {
        /** @var ServiceManager $serviceManager */
        $serviceManager = $this->getServiceLocator();

        /** @var UploadForm $form */
        $form = $serviceManager->get('UploadForm');

        if ($this->getRequest()->isPost()
            && ($form->setData($this->params()->fromPost() + $this->params()->fromFiles()))->isValid()) {

            /** @var string $fileName */
            $fileName = $form->getInputFilter()->getValues()['file']['tmp_name'];

            /** @var string $label */
            $label =  $this->params()->fromPost('description');

            /** @var string $userEmail */
            $userEmail = $serviceManager->get('AuthService')->getStorage()->read();

            /** @var UserRepository $userRepository */
            $userRepository = $serviceManager->get('UserRepository');

            /** @var User $user */
            $user = $userRepository->getUserByEmail($userEmail);

            /** @var int $userId */
            $userId = $user->id;

            /** @var array $data */
            $data = [];
            $data['filename'] = $fileName;
            $data['label'] = $label;
            $data['user_id'] = $userId;

            /** @var File $file */
            $file = new File();
            $file->exchangeArray($data);

            /** @var FileRepository $fileRepository */
            $fileRepository = $serviceManager->get('FileRepository');
            $fileRepository->saveFile($file);

            return $this->redirect()->toRoute(null, [
                'controller' => 'FileManager',
                'action' => 'index',
            ]);
        }

        return new ViewModel([
            'form' => $form,
        ]);
    }
}

