<?php
/**
 * Created by PhpStorm.
 * User: TinVo
 * Date: 10/24/13
 * Time: 11:18 AM
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AddWordController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
}