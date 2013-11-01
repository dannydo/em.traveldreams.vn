<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/23/13
 * Time: 2:16 PM
 */

namespace Application\Model;


use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;


class AccentTypeTable extends AbstractTableGateway {

    protected $table = 'AccentTypes';

    public function __construct() {
        $this->adapter = GlobalAdapterFeature::getStaticAdapter();

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new AccentType());
        $this->resultSetPrototype = $resultSetPrototype;
    }

    public function fetchAll() {
        return $this->select(array('IsActive' => 1));
    }
} 