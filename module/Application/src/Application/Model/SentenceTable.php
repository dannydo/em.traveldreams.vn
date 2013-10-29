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

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Sentence());
        $this->resultSetPrototype = $resultSetPrototype;
    }

    /**
     * @param $wordId
     * @param $sentence
     * @param $order
     * @return int
     */
    public function addEnSentenceForWord($wordId, $sentence, $order){
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
            'isApproved' => 0
        );

        return $this->insert($data)? $this->lastInsertValue : false;
    }

    /**
     * @param $wordId
     * @param $parentSentenceId
     * @param $sentence
     * @param $order
     * @return int
     */
    public function addViSentenceForWord($wordId, $parentSentenceId, $sentence, $order){
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
            'IsApproved' => 0
        );

        return $this->insert($data)? $this->lastInsertValue : false;
    }

     /**
     * Get list sentence by word and language
     *
     * @param int $wordId
     * @param int $languageId
     * @return null|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function getListSentence($wordId, $languageId) {
        $select = new Select();
        $select->from($this->table)
            ->where(array('WordId' => $wordId, 'LanguageId' => $languageId))
            ->order('Order ASC');

        return $this->selectWith($select);
    }

    /**
     * Update sentence
     *
     * @param $data
     * @return int
     */
    public function editSentence($data) {
        $now = new \DateTime();
        $data['UpdatedDate'] = $now->format('Y-m-d h:m:s');
        $data['UpdatedBy'] = 1;
        return $this->update($data, array('SentenceId' => $data['SentenceId']));
    }

    /**
     * Add sentence
     *
     * @param array $data
     * @return int
     */
    public function addSentence($data) {
        $now = new \DateTime();
        $data['CreatedDate'] = $now->format('Y-m-d h:m:s');
        $data['CreatedBy'] = 1;
        $data['IsActive'] = 1;
        if($this->insert($data)) {
            return $this->lastInsertValue;
        }

        return 0;
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