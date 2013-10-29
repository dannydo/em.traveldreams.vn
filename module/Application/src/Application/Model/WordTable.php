<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/23/13
 * Time: 2:19 PM
 */

namespace Application\Model;


use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

class WordTable extends AbstractTableGateway {

    protected $table = 'Words';

    public $arrStatus = Array(
        1 => 'NEED CONTENT',
        2 => 'WAITING APPROVE CONTENT',
        3 => 'NEED SOUND',
        4 => 'WAITING APPROVE SOUND',
        5 => 'COMPLETED'
    );

    public function __construct() {
        $this->adapter = GlobalAdapterFeature::getStaticAdapter();

//        $resultSetPrototype = new ResultSet();
//        $resultSetPrototype->setArrayObjectPrototype(new Word());
//        $this->resultSetPrototype = $resultSetPrototype;
    }

    /**
     * Fetch list word by status
     *
     * @param string $status
     * @param int $languageId
     * @return null|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function fetchListWordByStatus($status, $languageId = 1) {
        $select = new Select();
        $select->from($this->table)
            ->join('Meanings', 'Words.WordId = Meanings.WordId')
            ->where(array('Status' => $status, 'LanguageId' => $languageId, 'IsActive' => 1));

        return $this->selectWith($select);
    }

    /**
     * Get Word
     *
     * @param int $wordId
     * @return ResultSet
     */
    public function getWordByWordId($wordId) {
        return $this->select(array('WordId' => $wordId))->current();
    }

    public function editWord($data) {
        $now = new \DateTime();
        $data['UpdatedDate'] = $now->format('Y-m-d h:m:s');
        $this->update($data, array('WordId' => $data['WordId']));
    }
} 