<?php

namespace Files\Controller;

use Files\Entity\File;
use Files\Form\EditForm;
use Files\Form\UploadForm;
use Files\Repository\FileRepository;
use Users\Entity\User;
use Users\Repository\UserRepository;
use Zend\Db\ResultSet\ResultSet;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\ResponseInterface;
use Zend\View\Model\ViewModel;

/**
 * Class FileManagerController
 * @package Files\Controller
 */
class FileManagerController extends AbstractActionController
{
    /**
     * @return array|ViewModel
     * @throws \Exception
     */
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
        $files = $fileRepository->getUploadsByUserId($user->id);

        /** @var ResultSet $sharedFiles */
        $sharedFiles = $fileRepository->getSharedFilesForUserId($user->id);

        return new ViewModel([
            'files' => $files,
            'sharedFiles' => $sharedFiles,
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

    /**
     * @return \Zend\Http\Response|ViewModel
     * @throws \Exception
     */
    public function editAction()
    {
        /** @var ServiceManager $serviceManager */
        $serviceManager = $this->getServiceLocator();

        /** @var FileRepository $fileRepository */
        $fileRepository = $serviceManager->get('FileRepository');

        /** @var EditForm $form */
        $form = $serviceManager->get('EditForm');

        if ($this->getRequest()->isPost() && $form->setData($this->params()->fromPost())->isValid()) {
            /** @var int $userId */
            $userId = intval($form->getData()['select']);

            /** @var int $fileId */
            $fileId = intval($this->params()->fromRoute('id'));

            $fileRepository->addSharing($fileId, $userId);

            return $this->redirect()->toRoute(null, [
                'controller' => 'FilesManager',
                'action' => 'edit',
                'id' => $fileId,
            ]);

        }

        /** @var int $fileId */
        $fileId = intval($this->params()->fromRoute('id'));

        /** @var File $file */
        $file = $fileRepository->getFile($fileId);

        /** @var string` $fileName */
        $fileName = $file->filename;

        /** @var ResultSet $sharedUsers */
        $sharedUsers = $fileRepository->getSharedUsers($fileId);

        return new ViewModel([
            'fileId' => $fileId,
            'fileName' => $fileName,
            'sharedUsers' => $sharedUsers,
            'form' => $form,
        ]);
    }

    /**
     * @return \Zend\Http\Response
     * @throws \Exception
     */
    public function deleteAction()
    {
        /** @var ServiceManager $serviceManager */
        $serviceManager = $this->getServiceLocator();

        /** @var FileRepository $fileRepository */
        $fileRepository = $serviceManager->get('FileRepository');

        /** @var int $fileId */
        $fileId = intval($this->params()->fromRoute('id'));

        /** @var File $file */
        $file = $fileRepository->getFile($fileId);

        /** @var string` $fileName */
        $fileName = $file->filename;

        if (file_exists($fileName)) {
            unlink($fileName);
        }

        $fileRepository->deleteFile($fileId);

        return $this->redirect()->toRoute(null, [
            'controller' => 'FileManager',
            'action' => 'index',
        ]);
    }

    /**
     * @return \Zend\Http\Response
     */
    public function deleteSharingAction()
    {
        /** @var int $fileId */
        $fileId = intval($this->params()->fromRoute('id'));
        /** @var int $userId */
        $userId = intval($this->params()->fromRoute('userId'));

        /** @var FileRepository $fileRepository */
        $fileRepository = $this->getServiceLocator()->get('FileRepository');

        $fileRepository->deleteSharing($fileId, $userId);

        return $this->redirect()->toRoute(null, [
            'controller' => 'FileManger',
            'action' => 'edit',
            'id' => $fileId,
        ]);
    }

    /**
     * @return ResponseInterface
     * @throws \Exception
     */
    public function downloadAction()
    {
        /** @var int $fileId */
        $fileId = intval($this->params()->fromRoute('id'));

        /** @var FileRepository $fileRepository */
        $fileRepository = $this->getServiceLocator()->get('FileRepository');

        /** @var File $file */
        $file = $fileRepository->getFile($fileId);

        /** @var string $content */
        $content = file_get_contents($file->filename);

        /** @var ResponseInterface $response */
        $response = $this->getEvent()->getResponse();

        $response->getHeaders()->addHeaders([
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment;filename="' . basename($file->filename) . '"',
        ]);

        $response->setContent($content);

        return $response;
    }
}

