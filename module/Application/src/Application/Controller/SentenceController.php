<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/29/13
 * Time: 5:16 PM
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class SentenceController extends AbstractActionController
{

    public function indexAction() {
        return $this->redirect()->toRoute('application/default', array('controller' => 'index', 'action' => 'index'));
    }

    public function deleteAction() {
        die('successful');
    }

    public function approveAction() {
        die('successful');
    }
}