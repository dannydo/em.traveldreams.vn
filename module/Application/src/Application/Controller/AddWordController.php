<?php
/**
 * Created by PhpStorm.
 * User: TinVo
 * Date: 10/24/13
 * Time: 11:18 AM
 */

namespace Application\Controller;

use Application\Model\MeaningTable;
use Application\Model\SentenceTable;
use Application\Model\WordTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class AddWordController extends AbstractActionController
{
    protected $wordTable;
    protected $meaningTable;
    protected $sentenceTable;

    public function indexAction()
    {
       $request = $this->getRequest();

        $this->wordTable = new WordTable();
        $this->meaningTable = new MeaningTable();
        $this->sentenceTable = new SentenceTable();

        if($request->isPost()) {
            $dataPost = $request->getPost();

            // Add word
            $isToeic = (isset($dataPost['isToeic']) ? 1 : 0);
            $wordId = $this->wordTable->addNewWord($dataPost['word'],$isToeic);

            // Add tag for word
            $arrTag = mb_split(',', $dataPost['txtTags']);
            $this->wordTable->addTagsForWord($arrTag, $wordId);
            $this->wordTable->deletedTagsForWord($arrTag, $wordId);

            //Add meaning
            $this->meaningTable->addEnMeaningForWord($wordId, $dataPost['en-meaning']);
            $this->meaningTable->addViMeaningForWord($wordId, $dataPost['vi-meaning']);

            // add sentence for word
            $order = 0;
            foreach($dataPost['sentence'] as $sen){
                if($sen['en'] != '' || $sen['vi'] != ''){
                    $order++;
                    $senId = $this->sentenceTable->addEnSentenceForWord($wordId, $sen['en'], $order);
                    $this->sentenceTable->addViSentenceForWord($wordId, $senId, $sen['vi'], $order);
                }
            }

            if($order ==0){
                $senId = $this->sentenceTable->addEnSentenceForWord($wordId, "", $order);
                $this->sentenceTable->addViSentenceForWord($wordId, $senId, "", $order);
            }

            return $this->redirect()->toRoute('application/library',
                    array('controller' => 'library', 'action' => 'show-list', 'status'=>'wordId', 'wordId' => $wordId));
        }

        return new ViewModel();
    }

    public function checkWordAction()
    {
        $word = $this->params()->fromPost("word");

        $this->wordTable = new WordTable();
        $wordData = $this->wordTable->getWordsByWord($word);

        $data = array();
        foreach($wordData as $row){
            $data[] = array('wordId' => $row->WordId,
                            'word' => $row->Word,
                            'meaning' => $row->Meaning);
        }

        $result = new JsonModel($data);
        return $result;
    }
}