<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/31/13
 * Time: 6:41 PM
 */

namespace Application\View;

use Zend\View\Helper\AbstractHelper;

class MyHelper extends AbstractHelper
{

    protected $route;

    public function __construct($route) {
        $this->route = $route;
    }

    public function getAllParams() {
        $params = $this->route->getParams();
        return $params;
    }

    public function generatePathForFile($fileId, $type) {
        $folderName = (int)($fileId/1000 + 1);
        $dirFolderName = '/uploads/'.$folderName.'/'.$fileId.'.'.$type;

        return $dirFolderName;
    }

}