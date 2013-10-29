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

class MeaningTable extends AbstractTableGateway {

    protected $table = 'Meanings';

    public function __construct() {
        $this->adapter = GlobalAdapterFeature::getStaticAdapter();

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Meaning());
        $this->resultSetPrototype = $resultSetPrototype;
    }

    /**
     * add Enlish meaning for a word
     *
     * @param $wordId
     * @param $meaning
     * @return mixed
     */
    public function addEnMeaningForWord($wordId, $meaning){
        $now = new \DateTime();
        $data = array(
            'WordId' => $wordId,
            'LanguageId' => 1,
            'Meaning' => $meaning,
            'CreatedBy' => 1,
            'CreatedDate' => $now->format('Y-m-d h::s'),
            'UpdatedBy' => 1,
            'UpdatedDate' => $now->format('Y-m-d h::s'),
        );

        return $this->insert($data)? $this->lastInsertValue : false;
    }

    /**
     * add Vietnamese meaning for a word
     *
     * @param $wordId
     * @param $meaning
     * @return mixed
     */
    public function addViMeaningForWord($wordId, $meaning){
        $now = new \DateTime();
        $data = array(
            'WordId' => $wordId,
            'LanguageId' => 2,
            'Meaning' => $meaning,
            'CreatedBy' => 1,
            'CreatedDate' => $now->format('Y-m-d h::s'),
            'UpdatedBy' => 1,
            'UpdatedDate' => $now->format('Y-m-d h::s'),
        );

        return $this->insert($data)? $this->lastInsertValue : false;
    }

    /**
     * Get list meaning by word and language
     *
     * @param int $wordId
     * @param int $languageId
     * @return null|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function getListMeaning($wordId, $languageId) {
        $select = new Select();
        $select->from($this->table)
            ->where(array('WordId' => $wordId, 'LanguageId' => $languageId));

        return $this->selectWith($select);
    }
} 