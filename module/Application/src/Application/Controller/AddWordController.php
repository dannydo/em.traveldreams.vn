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
        if($request->isPost()) {
            $data = $request->getPost();

            $this->wordTable = new WordTable();
            $this->meaningTable = new MeaningTable();
            $this->sentenceTable = new SentenceTable();

            $wordId = $this->wordTable->addNewWord($data['word'],$data['isToeic']);
            $this->meaningTable->addEnMeaningForWord($wordId, $data['en-meaning']);
            $this->meaningTable->addViMeaningForWord($wordId, $data['vi-meaning']);

            $order = 1;
            foreach($data['sentence'] as $sen){
                if($sen['en'] != '' || $sen['vi'] != ''){
                    $senId = $this->sentenceTable->addEnSentenceForWord($wordId, $sen['en'], $order);
                    $this->sentenceTable->addViSentenceForWord($wordId, $senId, $sen['vi'], $order);
                    $order++;
                }
            }

            return $this->redirect('add-word');
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
            $data[] = array('word' => $row->Word,
                            'meaning' => $row->Meaning);
        }

        $result = new JsonModel($data);
        return $result;
    }
}