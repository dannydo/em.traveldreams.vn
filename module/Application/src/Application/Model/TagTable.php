<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/30/13
 * Time: 6:27 PM
 */

namespace Application\Model;


use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

class TagTable extends AbstractTableGateway {

    protected $table = 'Tags';

    public function __construct() {
        $this->adapter = GlobalAdapterFeature::getStaticAdapter();

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Tag());
        $this->resultSetPrototype = $resultSetPrototype;
    }

    /**
     * Fetch all tag
     *
     * @return ResultSet
     */
    public function fetchAllTags() {
        return $this->select(array('IsActive' => 1));
    }

    /**
     * Get tag by tag name
     *
     * @param $tagName
     * @return array|\ArrayObject|null
     */
    public function getTagByTagName($tagName) {
        return $this->select(array('TagName' => $tagName))->current();
    }

    /**
     * Add and Update tag
     *
     * @param $tagName
     * @return int
     */
    public function saveTags($tagName) {
        $data = array();
        $data['IsActive'] = 1;
        $data['TagName'] = $tagName;

        $tag = $this->getTagByTagName($tagName);
        if (isset($tag->TagId)) {
            $this->update($data, array('TagId' => $tag->TagId));
            return false;
        }
        else {
            if($this->insert($data)) {
                return $tagId = $this->lastInsertValue;
            };
        }

        return false;
    }
} 