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

    public function fetchAllTags() {
        return $this->select(array('IsActive' => 1));
    }
} 