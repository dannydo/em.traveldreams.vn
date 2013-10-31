<?php
/**
 * Created by JetBrains PhpStorm.
 * User: van.dao
 * Date: 10/30/13
 * Time: 8:44 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Model;


use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Debug\Debug;

class WordTagTable extends AbstractTableGateway {

    protected $table = 'WordTags';

    public function __construct() {
        $this->adapter = GlobalAdapterFeature::getStaticAdapter();
    }

    /**
     * Add word tag
     *
     * @param $data
     */
    public function saveWordTag($data) {
        $this->insert($data);
    }

    /**
     * Get all tag name for word
     *
     * @param $wordId
     * @return string
     */
    public function getAllTagNameForWord($wordId) {
        $select = new Select();
        $select->from($this->table)
            ->join('Tags', 'WordTags.TagId = Tags.TagId')
            ->where(array('WordId' => $wordId));

        $arrData = $this->selectWith($select);
        $strTagName = '';
        $total = $arrData->count();
        $index=0;
        foreach($arrData as $item) {
            if ($index < $total-1) {
                $strTagName = $strTagName . $item->TagName . ',';
            }
            else {
                $strTagName = $strTagName . $item->TagName;
            }
            $index++;
        }

        return $strTagName;
    }

    /**
     * Get all tag for word
     *
     * @param $wordId
     * @return null|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function getAllTagForWord($wordId) {
        $select = new Select();
        $select->from($this->table)
            ->join('Tags', 'WordTags.TagId = Tags.TagId')
            ->where(array('WordId' => $wordId));

        return $this->selectWith($select);
    }

    /**
     * Delete word tag
     *
     * @param $wordTagId
     */
    public function deleteWordTag($wordTagId) {
        $this->delete(array('WordTagId' => $wordTagId));
    }
}