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

    /**
     * Update word
     *
     * @param $data
     * @return int
     */
    public function editWord($data) {
        $now = new \DateTime();
        $data['UpdatedDate'] = $now->format('Y-m-d h:m:s');
        $data['UpdatedBy'] = 1;
        return $this->update($data, array('WordId' => $data['WordId']));
    }

    /**
     * Add new word
     *
     * @param $word
     * @param $isToeic
     * @return mixed
     */
    public function addNewWord($word, $isToeic)
    {
        $now = new \DateTime();
        $data = array(
            'Word' => $word,
            'Status' => 'NEED CONTENT',
            'IsToeic' => $isToeic ? 1 : 0,
            'IsActive' => 1,
            'CreatedBy' => 1,
            'CreatedDate' => $now->format('Y-m-d h::s'),
            'UpdatedBy' => 1,
            'UpdatedDate' => $now->format('Y-m-d h::s'),
        );
        return $this->insert($data)? $this->lastInsertValue : false;
    }

    /**
     * get words by word
     *
     * @param $word
     * @param int $languageId
     * @return null|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function getWordsByWord($word, $languageId = 1){
        $select = new Select();
        $select->from($this->table)
            ->join('Meanings', 'Words.WordId = Meanings.WordId')
            ->where(array('Word' => $word, 'LanguageId' => $languageId, 'IsActive' => 1));

        return $this->selectWith($select);
    }

    public function addTagsForWord($arrTagName, $wordId) {

        $tagTable = new TagTable();
        $wordTagTable = new WordTagTable();

        foreach($arrTagName as $tagName) {
            $data['TagId'] = $tagTable->saveTags($tagName);
            $data['WordId'] = $wordId;

            if ($data['TagId']) {
                $wordTagTable->addWordTag($data);
            }
        }

        $arrTagNameOld = $wordTagTable->getAllTagForWord($wordId);
        foreach($arrTagNameOld as $tagOld) {
            $isDelete = true;
            foreach($arrTagName as $tagName) {
                if ($tagOld->TagName == $tagName) {
                    $isDelete = false;
                    break;
                }
            }
            if($isDelete) {
                $wordTagTable->deleteWordTag($tagOld->WordTagId);
            }
        }
    }
} 