<?php
/**
 * Created by PhpStorm.
 * User: Van Dao
 * Date: 10/23/13
 * Time: 1:53 PM
 */

namespace Dictionary\Model;

class ENVI {

    public $wordId;
    public $word;
    public $definition;

    public function exchangeArray($data)
    {
        $this->wordId     = (!empty($data['WordId'])) ? $data['WordId'] : null;
        $this->word = (!empty($data['Word'])) ? $data['Word'] : null;
        $this->definition  = (!empty($data['Definition'])) ? $data['Definition'] : null;
    }
} 