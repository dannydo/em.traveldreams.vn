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

class WordController extends AbstractActionController
{

    protected $wordTable;
    protected $languageTable;
    protected $meaningTable;
    protected $sentenceTable;

    public function indexAction()
    {
        return $this->redirect()->toRoute('application/default', array('controller' => 'index', 'action' => 'index'));
    }

    public function getWordAction() {
        $wordId = $this->params()->fromRoute('wordId', 0);
        echo $wordId;
        $this->languageTable = new LanguageTable();
        $this->wordTable = new WordTable();
        $this->meaningTable = new MeaningTable();
        $this->sentenceTable = new SentenceTable();

        $data = array();
        $data['Word'] = $this->wordTable->getWordByWordId($wordId);
        $data['SentenceEN'] = $this->sentenceTable->getListSentence($wordId, $this->languageTable->arrLanguage['EN']);
        $data['SentenceVI'] = $this->sentenceTable->getListSentence($wordId, $this->languageTable->arrLanguage['VI']);
        $data['MeaningEN'] = $this->meaningTable->getListMeaning($wordId, $this->languageTable->arrLanguage['EN']);
        $data['MeaningVI'] = $this->meaningTable->getListMeaning($wordId, $this->languageTable->arrLanguage['VI']);

        $view = new ViewModel(
            array(
                'data' => $data,
            )
        );
        $view->setTerminal(true);
        return $view;
    }

}