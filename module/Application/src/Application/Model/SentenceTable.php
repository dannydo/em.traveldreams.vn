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

    public function editSentence($data) {
        $now = new \DateTime();
        $data['UpdatedDate'] = $now->format('Y-m-d h:m:s');
        $this->update($data, array('SentenceId' => $data['SentenceId']));
    }

    public function addSentence($data) {
        $now = new \DateTime();
        $data['CreatedDate'] = $now->format('Y-m-d h:m:s');
        if($this->insert($data)) {
            return $this->lastInsertValue;
        }

        return 0;
    }
} 