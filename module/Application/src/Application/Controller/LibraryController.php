<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/25/13
 * Time: 10:04 AM
 */

namespace Application\Controller;

use Application\Model\LanguageTable;
use Application\Model\WordTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LibraryController extends AbstractActionController
{

    protected $wordTable;
    protected $languageTable;

    public function indexAction() {
        return $this->redirect()->toRoute('application/library', array('controller' => 'library', 'action' => 'show-list', 'status'=>'NEED CONTENT'));
    }

    public function showListAction() {
        $status = strtoupper($this->params()->fromRoute('status', ''));
        $wordId = strtoupper($this->params()->fromRoute('wordId', ''));

        $this->wordTable = new WordTable();
        $this->languageTable = new LanguageTable();
        $words = array();

        if (is_numeric($wordId) && $wordId > 0 && $status == 'WORDID') {
            $word = $this->wordTable->getWordByWordId($wordId);
            if (isset($word->WordId)) {
                $words = $this->wordTable->getWordsByWord($word->Word, $this->languageTable->arrLanguage['EN']);
            }
        }
        else {
            $words = $this->wordTable->fetchListWordByStatus($status, $this->languageTable->arrLanguage['EN']);
        }

        return new ViewModel(
            array(
                'words' => $words,
            )
        );
    }

}