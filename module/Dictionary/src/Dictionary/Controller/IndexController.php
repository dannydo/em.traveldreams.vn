<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/23/13
 * Time: 1:22 PM
 */

namespace Dictionary\Controller;

use Application\Model\AlbumTable;
use Dictionary\Model\ENVITable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Debug\Debug;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    protected $dbAdapter;
    protected $enVITable;


    public function indexAction() {
        $this->getAdapter();
        $this->enVITable = new ENVITable($this->dbAdapter);

        return new ViewModel(
            array(
                'dictionaries' => $this->enVITable->fetchAll(),
            )
        );
    }

    private function getAdapter() {
        $serviceManager = $this->getServiceLocator();
        $this->dbAdapter = $serviceManager->get('db_dictionary');
    }

    public function dictionaryAction() {
        $this->getAdapter();
        $this->enVITable = new ENVITable($this->dbAdapter);

        $word = $this->params()->fromQuery('word', 0);

        $dictionaries = $this->enVITable->searchWordByWord(strtolower($word));

        $arr = array();
        foreach($dictionaries as $word) {
                $arr[] = $word['Word'];
        }

        $result = new JsonModel($arr);
        return $result;

    }

    public function getWordAction() {
        $this->getAdapter();
        $this->enVITable = new ENVITable($this->dbAdapter);

        $word = $this->params()->fromPost('word', "");
        if($word != ""){
            $dict = $this->enVITable->getWordByWord(strtolower($word));

            //google dictionary
            $url = "http://www.google.com/dictionary/json?callback=a&client=p&sl=en&tl=en&q=";
            $file = file_get_contents($url . urlencode($word));
            $file = substr($file, 2, -10);
            $file = preg_replace("/\\\x[0-9a-f]{2}/", "", $file);
            $json = json_decode($file);

            $en_meaning = "";
            if(isset($json->primaries)){
                $json = $json->primaries[0]->entries;
                foreach($json as $entry){
                    if($entry->type == "meaning"){
                        $en_meaning .= '- ' . $entry->terms[0]->text . PHP_EOL;
                    }
                }
            }

            $result = new JsonModel(array(
                'Word' =>  $dict->word,
                'EN' =>  $en_meaning,
                'VI' => strip_tags($dict->definition)
            ));
            return $result;
        }
        return "false";
    }

}