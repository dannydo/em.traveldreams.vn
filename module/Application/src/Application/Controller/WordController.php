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
use Application\Model\TagTable;
use Application\Model\WordTable;
use Application\Model\WordTagTable;
use Zend\Debug\Debug;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class WordController extends AbstractActionController
{

    protected $wordTable;
    protected $languageTable;
    protected $meaningTable;
    protected $sentenceTable;
    protected $wordTagTable;

    public function indexAction() {
        return $this->redirect()->toRoute('application/default', array('controller' => 'index', 'action' => 'index'));
    }

    public function getWordAction() {
        $wordId = $this->params()->fromRoute('wordId', 0);

        $this->languageTable = new LanguageTable();
        $this->wordTable = new WordTable();
        $this->meaningTable = new MeaningTable();
        $this->sentenceTable = new SentenceTable();
        $this->wordTagTable = new WordTagTable();

        // update and insert data
        $request = $this->getRequest();
        if ($request->isPost()) {
            $dataPost = $request->getPost();

            // Update word
            $wordId = $dataPost['wordId'];
            $isToeic = (isset($dataPost['isToeic']) ? 1 : 0);
            $this->wordTable->editWord($wordId,  $dataPost['txtWord'], $isToeic, $this->wordTable->arrStatus['1']);

            // Add tag for word
            $arrTag = mb_split(',', $dataPost['txtTags']);
            $this->wordTable->addTagsForWord($arrTag, $wordId);
            $this->wordTable->deletedTagsForWord($arrTag, $wordId);

            // Update meaning for word
            $this->meaningTable->editMeaning($dataPost['id-meaningEN'], $dataPost['meaningEN'], $dataPost['approve-meaningEN']);
            $this->meaningTable->editMeaning($dataPost['id-meaningVI'], $dataPost['meaningVI'], $dataPost['approve-meaningVI']);

            // Update and add sentence for word
            for($nSentence=0; $nSentence < count($dataPost['id-sentencesEN']); $nSentence++) {
                if ( $dataPost['id-sentencesEN'][$nSentence] != '' && is_numeric($dataPost['id-sentencesEN'][$nSentence])) {
                    $this->sentenceTable->editSentence($dataPost['id-sentencesEN'][$nSentence],
                        $dataPost['content-sentencesEN'][$nSentence], $nSentence + 1, $dataPost['approve-sentenceEN'][$nSentence]);

                    $this->sentenceTable->editSentence($dataPost['id-sentencesVI'][$nSentence],
                        $dataPost['content-sentencesVI'][$nSentence], $nSentence + 1, $dataPost['approve-sentenceVI'][$nSentence]);
                } else if (trim($dataPost['content-sentencesEN'][$nSentence]) != '' || trim($dataPost['content-sentencesVI'][$nSentence]) != '') {

                    $sentenceId = $this->sentenceTable->addEnSentenceForWord($wordId, $dataPost['content-sentencesEN'][$nSentence],
                        $nSentence + 1, $dataPost['approve-sentenceEN'][$nSentence]);

                    if($sentenceId > 0) {
                        $this->sentenceTable->addViSentenceForWord($wordId, $sentenceId, $dataPost['content-sentencesVI'][$nSentence],
                            $nSentence + 1, $dataPost['approve-sentenceVI'][$nSentence]);
                    }
                }
            }

            // Delete sentence for word
            $arrDeleteSentence = mb_split(',', $dataPost['txtDeleteSentence']);
            foreach($arrDeleteSentence as $sentenceId) {
                if (is_numeric($sentenceId)) {
                    $this->sentenceTable->deleteSentenceByParentSentenceId($sentenceId);
                    $this->sentenceTable->deleteSentence($sentenceId);
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
        $data['TagName'] = $this->wordTagTable->getAllTagNameForWord($wordId);

        $this->wordTable->autoCheckAndUpdateStatusWord($data['Word'], $data['SentenceEN'], $data['SentenceVI'], $data['MeaningEN'], $data['MeaningVI']);

        $view = new ViewModel(
            array(
                'data' => $data,
            )
        );
        $view->setTerminal(true);
        return $view;
    }

}