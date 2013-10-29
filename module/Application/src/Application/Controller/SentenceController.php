<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/29/13
 * Time: 5:16 PM
 */

namespace Application\Controller;

use Application\Model\SentenceTable;
use Zend\Mvc\Controller\AbstractActionController;

class SentenceController extends AbstractActionController
{

    public function indexAction() {
        return $this->redirect()->toRoute('application/default', array('controller' => 'index', 'action' => 'index'));
    }

    public function deleteAction() {
        $sentenceId = $this->params()->fromRoute('sentenceId', 0);
        echo $sentenceId;
        $sentenceTable = new SentenceTable();
        $sentence = $sentenceTable->getSentenceById($sentenceId);

        if(!is_null($sentence)) {
            if(is_null($sentence->ParentSentenceId)) {
                $sentenceTable->deleteSentenceByParentSentenceId($sentenceId);
                $sentenceTable->deleteSentence($sentenceId);
            } else {
                $sentenceTable->deleteSentenceByParentSentenceId($sentence->ParentSentenceId);
                $sentenceTable->deleteSentence($sentence->ParentSentenceId);
            }
        }

        die('successful');
    }

    public function approveAction() {
        $sentence['SentenceId'] = $this->params()->fromRoute('sentenceId', 0);
        $sentence['IsApproved'] = $this->params()->fromRoute('isApproved', '');
        $sentenceTable = new SentenceTable();
        $sentenceTable->editSentence($sentence);

        die('successful');
    }
}