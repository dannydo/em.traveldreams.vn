<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/23/13
 * Time: 2:18 PM
 */

namespace Application\Model;


use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Debug\Debug;

class SentenceTable extends AbstractTableGateway {

    protected $table = 'Sentences';

    public function __construct() {
        $this->adapter = GlobalAdapterFeature::getStaticAdapter();
    }

    /**
     * @param $wordId
     * @param $sentence
     * @param $order
     * @param $isApproved
     * @return int
     */
    public function addEnSentenceForWord($wordId, $sentence, $order, $isApproved = 0){
        $now = new \DateTime();
        $data = array(
            'wordId' => $wordId,
            'languageId' => 1,
            'parentSentenceId' => null,
            'sentence' => $sentence,
            'order' => $order,
            'createdBy' => 1,
            'createdDate' => $now->format('Y-m-d h::s'),
            'updatedBy' => 1,
            'updatedDate' => $now->format('Y-m-d h::s'),
            'isActive' => 1,
            'isApproved' => $isApproved
        );

        return $this->insert($data)? $this->lastInsertValue : false;
    }

    /**
     * @param $wordId
     * @param $parentSentenceId
     * @param $sentence
     * @param $order
     * @param $isApproved
     * @return int
     */
    public function addViSentenceForWord($wordId, $parentSentenceId, $sentence, $order, $isApproved = 0){
        $now = new \DateTime();
        $data = array(
            'WordId' => $wordId,
            'LanguageId' => 2,
            'ParentSentenceId' => $parentSentenceId,
            'Sentence' => $sentence,
            'Order' => $order,
            'CreatedBy' => 1,
            'CreatedDate' => $now->format('Y-m-d h::s'),
            'UpdatedBy' => 1,
            'UpdatedDate' => $now->format('Y-m-d h::s'),
            'IsActive' => 1,
            'IsApproved' => $isApproved
        );

        return $this->insert($data)? $this->lastInsertValue : false;
    }

     /**
     * Get list sentence by word and language
     *
     * @param int $wordId
     * @param int $languageId
     * @return array
     */
    public function getListSentence($wordId, $languageId) {
        $select = new Select();
        $select->from($this->table)
            ->where(array('WordId' => $wordId, 'LanguageId' => $languageId))
            ->order('Order ASC');

        $records = array();
        foreach($this->selectWith($select) as $obj) {
            $records[] = $obj;
        }
        return $records;
    }

    /**
     * Update sentence
     *
     * @param $sentenceId
     * @param $sentence
     * @param $order
     * @param $isApproved
     * @return int
     */
    public function editSentence($sentenceId, $sentence, $order, $isApproved) {
        $now = new \DateTime();
        $data['SentenceId'] =$sentenceId;
        $data['Sentence'] = $sentence;
        $data['Order'] = $order;
        $data['IsApproved'] = $isApproved;
        $data['UpdatedDate'] = $now->format('Y-m-d h:m:s');
        $data['UpdatedBy'] = 1;
        return $this->update($data, array('SentenceId' => $data['SentenceId']));
    }

    /**
     * Delete sentence
     *
     * @param $sentenceId
     * @return int
     */
    public function deleteSentence($sentenceId) {
        return $this->delete(array('SentenceId' => $sentenceId));
    }

    /**
     * Delete sentences by parent sentence id
     *
     * @param $parentSentenceId
     * @return int
     */
    public function deleteSentenceByParentSentenceId($parentSentenceId) {
        return $this->delete(array('ParentSentenceId' => $parentSentenceId));
    }

    /**
     * Get sentence by sentence id
     *
     * @param $sentenceId
     * @return array|\ArrayObject|null
     */
    public function getSentenceById($sentenceId) {
        return $this->select(array('SentenceId' => $sentenceId))->current();
    }
} 