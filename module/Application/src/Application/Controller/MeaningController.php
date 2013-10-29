<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/29/13
 * Time: 5:16 PM
 */

namespace Application\Controller;

use Application\Model\MeaningTable;
use Zend\Mvc\Controller\AbstractActionController;

class MeaningController extends AbstractActionController
{

    public function indexAction() {
        return $this->redirect()->toRoute('application/default', array('controller' => 'index', 'action' => 'index'));
    }

    public function approveAction() {
        $meaning['MeaningId'] = $this->params()->fromRoute('meaningId', 0);
        $meaning['IsApproved'] = $this->params()->fromRoute('isApproved', '');
        $meaningTable = new MeaningTable();
        $meaningTable->editMeaning($meaning);

        die('successful');
    }
}