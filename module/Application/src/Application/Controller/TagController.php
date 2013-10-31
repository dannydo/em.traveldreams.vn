<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/30/13
 * Time: 6:38 PM
 */

namespace Application\Controller;


use Application\Model\TagTable;
use Zend\Debug\Debug;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class TagController extends AbstractActionController {

    public function indexAction() {
        return $this->redirect()->toRoute('application/default', array('controller' => 'index', 'action' => 'index'));
    }

    public function getTagsAction()
    {
        $tagTable = new TagTable();
        $tags = $tagTable->fetchAllTags();

        $arrTag = array();
        foreach($tags as $tag) {
            if(!is_null($tag->TagName) && $tag->TagName != '') {
                $arrTag[] = $tag->TagName;
            }
        }

        $result = new JsonModel($arrTag);
        return $result;
    }
}