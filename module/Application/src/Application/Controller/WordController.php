<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/25/13
 * Time: 10:04 AM
 */

namespace Application\Controller;

use Application\Model\AccentTypeTable;
use Application\Model\FileTable;
use Application\Model\LanguageTable;
use Application\Model\MeaningTable;
use Application\Model\SentenceTable;
use Application\Model\VoiceTable;
use Application\Model\WordTable;
use Application\Model\WordTagTable;
use Zend\Debug\Debug;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class WordController extends AbstractActionController
{

    public function indexAction() {
        return $this->redirect()->toRoute('application/default', array('controller' => 'index', 'action' => 'index'));
    }

    public function getWordAction() {
        $wordId = $this->params()->fromRoute('wordId', 0);

        $languageTable = new LanguageTable();
        $wordTable = new WordTable();
        $meaningTable = new MeaningTable();
        $sentenceTable = new SentenceTable();
        $wordTagTable = new WordTagTable();
        $accentTypeTable = new AccentTypeTable();

        $config = $this->getServiceLocator()->get("Config");
        $voiceTable = new VoiceTable($config['application']['path_upload']);
        $fileTable = new FileTable($config['application']['path_upload']);

        // update and insert data
        $request = $this->getRequest();
        if ($request->isPost()) {
            $dataPost = $request->getPost();

            // Update word
            $wordId = $dataPost['wordId'];
            $isToeic = (isset($dataPost['isToeic']) ? 1 : 0);
            $wordTable->editWord($wordId,  $dataPost['txtWord'], $isToeic, $wordTable->arrStatus['1']);

            // Add tag for word
            $arrTag = mb_split(',', $dataPost['txtTags']);
            $wordTable->addTagsForWord($arrTag, $wordId);
            $wordTable->deletedTagsForWord($arrTag, $wordId);

            // Add voice for word
            $nAdd = 0;
            for($nVoice=0; $nVoice<count($dataPost['voiceTypeWord'])-1; $nVoice++) {
                if($dataPost['chooseFile'][$nVoice] == 1) {
                    $dataFile['name'] = $_FILES['voiceFileWord']['name'][$nAdd];
                    $dataFile['type'] = $_FILES['voiceFileWord']['type'][$nAdd];
                    $dataFile['tmp_name'] = $_FILES['voiceFileWord']['tmp_name'][$nAdd];
                    $dataFile['size'] = $_FILES['voiceFileWord']['size'][$nAdd];
                    $dataFile['error'] = $_FILES['voiceFileWord']['error'][$nAdd];

                    $fileId = $fileTable->addFile($dataFile);
                    if($fileId) {
                        $voiceTable->addVoiceForWord($dataPost['voiceTypeWord'][$nVoice], $fileId, $languageTable->arrLanguage['EN'], $wordId);
                    }
                    $nAdd++;
                }
            }

            // Delete voice for word
            $arrVoiceWordId = mb_split(',', $dataPost['arrIdVoiceDelete']);
            $voiceTable->deleteVoices($arrVoiceWordId);

            // Approve voice for word
            for($nVoiceExists=0; $nVoiceExists<count($dataPost['idVoice']); $nVoiceExists++) {
                $voiceTable->approveVoice($dataPost['idVoice'][$nVoiceExists], $dataPost['approveVoice'][$nVoiceExists]);
            }

            // Update meaning for word
            $meaningTable->editMeaning($dataPost['id-meaningEN'], $dataPost['meaningEN'], $dataPost['approve-meaningEN']);
            $meaningTable->editMeaning($dataPost['id-meaningVI'], $dataPost['meaningVI'], $dataPost['approve-meaningVI']);

            // Update and add sentence for word
            for($nSentence=0; $nSentence < count($dataPost['id-sentencesEN']); $nSentence++) {
                if ( $dataPost['id-sentencesEN'][$nSentence] != '' && is_numeric($dataPost['id-sentencesEN'][$nSentence])) {
                    $sentenceTable->editSentence($dataPost['id-sentencesEN'][$nSentence],
                        $dataPost['content-sentencesEN'][$nSentence], $nSentence + 1, $dataPost['approve-sentenceEN'][$nSentence]);

                    $sentenceTable->editSentence($dataPost['id-sentencesVI'][$nSentence],
                        $dataPost['content-sentencesVI'][$nSentence], $nSentence + 1, $dataPost['approve-sentenceVI'][$nSentence]);
                } else if (trim($dataPost['content-sentencesEN'][$nSentence]) != '' || trim($dataPost['content-sentencesVI'][$nSentence]) != '') {

                    $sentenceId = $sentenceTable->addEnSentenceForWord($wordId, $dataPost['content-sentencesEN'][$nSentence],
                        $nSentence + 1, $dataPost['approve-sentenceEN'][$nSentence]);

                    if($sentenceId > 0) {
                        $sentenceTable->addViSentenceForWord($wordId, $sentenceId, $dataPost['content-sentencesVI'][$nSentence],
                            $nSentence + 1, $dataPost['approve-sentenceVI'][$nSentence]);
                    }
                }
            }

            // Delete sentence for word
            $arrDeleteSentence = mb_split(',', $dataPost['txtDeleteSentence']);
            foreach($arrDeleteSentence as $sentenceId) {
                if (is_numeric($sentenceId)) {
                    $sentenceTable->deleteSentenceByParentSentenceId($sentenceId);
                    $sentenceTable->deleteSentence($sentenceId);
                }
            }
        }

        // get data
        $data = array();
        $data['Word'] = $wordTable->getWordByWordId($wordId);
        $data['SentenceEN'] = $sentenceTable->getListSentence($wordId, $languageTable->arrLanguage['EN']);
        $data['SentenceVI'] = $sentenceTable->getListSentence($wordId, $languageTable->arrLanguage['VI']);
        $data['MeaningEN'] = $meaningTable->getListMeaning($wordId, $languageTable->arrLanguage['EN']);
        $data['MeaningVI'] = $meaningTable->getListMeaning($wordId, $languageTable->arrLanguage['VI']);
        $data['TagName'] = $wordTagTable->getAllTagNameForWord($wordId);
        $data['WordVoicesEN'] = $voiceTable->getVoicesForWord($wordId, $languageTable->arrLanguage['EN']);
        $data['AccentTypes'] = $accentTypeTable->fetchAll();

        if ($request->isPost()) {
            $wordTable->autoCheckAndUpdateStatusWord($data['Word'], $data['SentenceEN'], $data['SentenceVI'], $data['MeaningEN'], $data['MeaningVI'], $data['WordVoicesEN']);
        }

        $view = new ViewModel(
            array(
                'data' => $data,
            )
        );
        $view->setTerminal(true);
        return $view;
    }

}