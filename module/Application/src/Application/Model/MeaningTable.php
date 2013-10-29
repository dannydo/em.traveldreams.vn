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
     * Get list meaning by word and language
     *
     * @param int $wordId
     * @param int $languageId
     * @return null|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function getListMeaning($wordId, $languageId) {
        return $this->select(array('WordId' => $wordId, 'LanguageId' => $languageId))->current();
    }

    public function editMeaning($data) {
        $now = new \DateTime();
        $data['UpdatedDate'] = $now->format('Y-m-d h:m:s');
        $this->update($data, array('MeaningId' => $data['MeaningId']));
    }
} 