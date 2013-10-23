<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/23/13
 * Time: 1:22 PM
 */

namespace Dictionary\Controller;

use Application\Model\AlbumTable;
use Dictionary\Model\ENVITable;
use Zend\Debug\Debug;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    protected $dbAdapter;
    protected $enVITable;


    public function indexAction() {
        $this->getAdapter();
        $this->enVITable = new ENVITable($this->dbAdapter);
        Debug::dump($this->enVITable->fetchAll()->current());

        return new ViewModel(
            array(
            )
        );
    }

    private function getAdapter() {
        $serviceManager = $this->getServiceLocator();
        $this->dbAdapter = $serviceManager->get('db_dictionary');
    }
} 