<?php

namespace CurrentTime\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class TimeController
 * @package CurrentTime\Controller
 */
class TimeController extends AbstractActionController
{
    /**
     * @return array|ViewModel
     */
    public function indexAction()
    {
        /** @var \DateTime $dateTime */
        $dateTime = new \DateTime();
        /** @var string $currentTime */
        $currentTime = $dateTime->format('H:i:s e d-m-Y');

        return new ViewModel([
            'currentTime' => $currentTime,
        ]);
    }
}
