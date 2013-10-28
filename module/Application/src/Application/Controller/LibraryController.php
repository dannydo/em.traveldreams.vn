<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/25/13
 * Time: 10:04 AM
 */

namespace Application\Controller;

use Dictionary\Model\ENVITable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LibraryController extends AbstractActionController
{

    protected $dbAdapter;
    protected $enVITable;

    public function indexAction()
    {
        return $this->redirect()->toRoute('application/default', array('controller' => 'library', 'action' => 'show-list'));
    }

    public function showListAction()
    {
        $this->getAdapter();
        $this->enVITable = new ENVITable($this->dbAdapter);

        return new ViewModel(
            array(
                'dictionaries' => $this->enVITable->fetchAll(),
            )
        );
    }

    private function getAdapter() {
        $serviceManager = $this->getServiceLocator();
        $this->dbAdapter = $serviceManager->get('db_dictionary');
    }

}