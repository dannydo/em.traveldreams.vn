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
use Zend\Debug\Debug;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class WordController extends AbstractActionController
{

    protected $wordTable;
    protected $languageTable;
    protected $meaningTable;
    protected $sentenceTable;

    public function indexAction() {
        return $this->redirect()->toRoute('application/default', array('controller' => 'index', 'action' => 'index'));
    }

    public function getWordAction() {
        $userId = 1;
        $wordId = $this->params()->fromRoute('wordId', 0);

        $this->languageTable = new LanguageTable();
        $this->wordTable = new WordTable();
        $this->meaningTable = new MeaningTable();
        $this->sentenceTable = new SentenceTable();

        // update and insert data
        $request = $this->getRequest();
        if ($request->isPost()) {
            $dataPost = $request->getPost();

            // Update word
            $wordId = $dataPost['wordId'];
            $word['WordId'] = $dataPost['wordId'];
            $word['Word'] = $dataPost['txtWord'];
            $word['UpdatedBy'] = $userId;
            $this->wordTable->editWord($word);

            // Update meaning for word
            $meaning['MeaningId'] = $dataPost['id-meaningEN'];
            $meaning['Meaning'] = $dataPost['meaningEN'];
            $meaning['UpdatedBy'] = $userId;
            $this->meaningTable->editMeaning($meaning);

            $meaning['MeaningId'] = $dataPost['id-meaningVI'];
            $meaning['Meaning'] = $dataPost['meaningVI'];
            $this->meaningTable->editMeaning($meaning);

            // Update and add sentence for word
            for($nSentence=0; $nSentence < count($dataPost['id-sentencesEN']); $nSentence++) {
                if ( $dataPost['id-sentencesEN'][$nSentence] != '' && is_numeric($dataPost['id-sentencesEN'][$nSentence])) {
                    $sentence['SentenceId'] = $dataPost['id-sentencesEN'][$nSentence];
                    $sentence['Sentence'] = $dataPost['content-sentencesEN'][$nSentence];
                    $sentence['UpdatedBy'] = $userId;
                    $this->sentenceTable->editSentence($sentence);

                    $sentence['SentenceId'] = $dataPost['id-sentencesVI'][$nSentence];
                    $sentence['Sentence'] = $dataPost['content-sentencesVI'][$nSentence];
                    $this->sentenceTable->editSentence($sentence);
                } else {
                    $sentence['LanguageId'] = $this->languageTable->arrLanguage['EN'];
                    $sentence['WordId'] = $wordId;
                    $sentence['Sentence'] = $dataPost['content-sentencesEN'][$nSentence];
                    $sentence['CreatedBy'] = $userId;
                    unset($sentence['SentenceId']);
                    $sentenceId = $this->sentenceTable->addSentence($sentence);

                    if($sentenceId > 0) {
                        $sentence['ParentSentenceId'] = $sentenceId;
                        $sentence['LanguageId'] = $this->languageTable->arrLanguage['VI'];
                        $sentence['Sentence'] = $dataPost['content-sentencesVI'][$nSentence];
                        $this->sentenceTable->addSentence($sentence);
                    }
                }
            }
        }

        // get data
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