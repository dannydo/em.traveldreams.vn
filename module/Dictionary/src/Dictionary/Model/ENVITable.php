<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/23/13
 * Time: 1:53 PM
 */

namespace Dictionary\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class ENVITable extends AbstractTableGateway {

    protected $table = 'EN_VI';

    public function __construct(Adapter $dbAdapter) {
        $this->adapter = $dbAdapter;

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new ENVI());
        $this->resultSetPrototype = $resultSetPrototype;
    }

    public function fetchAll() {
        $resultSet =  $this->select();
        return $resultSet;
    }
} 