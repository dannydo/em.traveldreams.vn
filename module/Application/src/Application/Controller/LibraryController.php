<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/25/13
 * Time: 10:04 AM
 */

namespace Application\Controller;

use Application\Model\LanguageTable;
use Application\Model\MeaningTable;
use Application\Model\SentenceTable;
use Application\Model\WordTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LibraryController extends AbstractActionController
{

    protected $wordTable;
    protected $languageTable;

    public function indexAction()
    {
        return $this->redirect()->toRoute('application/default', array('controller' => 'library', 'action' => 'show-list'));
    }

    public function showListAction()
    {
        $status = strtoupper($this->params()->fromRoute('status', ''));
        $this->wordTable = new WordTable();
        $this->languageTable = new LanguageTable();

        return new ViewModel(
            array(
                'words' => $this->wordTable->fetchListWordByStatus($status, $this->languageTable->arrLanguage['EN']),
            )
        );
    }

}