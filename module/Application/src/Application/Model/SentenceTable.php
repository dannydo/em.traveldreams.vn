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
        $data = array(
            'wordId' => $wordId,
            'languageId' => 1,
            'parentSentenceId' => null,
            'sentence' => $sentence,
            'order' => $order,
            'createdBy' => 1,
            'createdDate' => new \DateTime(),
            'updatedBy' => 1,
            'updatedDate' => new \DateTime(),
            'isActive' => 1,
            'isApproved' => 0
        );

        return $this->insert($data);
    }

    /**
     * @param $wordId
     * @param $parentSentenceId
     * @param $sentence
     * @param $order
     * @return int
     */
    public function addViSentenceForWord($wordId, $parentSentenceId, $sentence, $order){
        $data = array(
            'wordId' => $wordId,
            'languageId' => 2,
            'parentSentenceId' => $parentSentenceId,
            'sentence' => $sentence,
            'order' => $order,
            'createdBy' => 1,
            'createdDate' => new \DateTime(),
            'updatedBy' => 1,
            'updatedDate' => new \DateTime(),
            'isActive' => 1,
            'isApproved' => 0
        );

        return $this->insert($data);
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
} 