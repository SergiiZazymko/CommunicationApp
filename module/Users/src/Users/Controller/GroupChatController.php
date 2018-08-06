<?php

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class GroupChatController
 * @package Users\Controller
 */
class GroupChatController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
}
