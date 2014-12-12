<?php

namespace biz\core\base\rest;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * Description of ViewAction
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  * @since 3.0
 */
class IndexAction extends Action
{
    public $prepareDataProvider;
    
    public function run()
    {
        $this->api->fire('_list');
        return $this->prepareDataProvider();
    }

    /**
     * Prepares the data provider that should return the requested collection of the models.
     * @return ActiveDataProvider
     */
    protected function prepareDataProvider()
    {
        if ($this->prepareDataProvider !== null) {
            return call_user_func($this->prepareDataProvider, $this);
        }

        /* @var $modelClass \yii\db\BaseActiveRecord */
        $modelClass = $this->api->modelClass;
        return new ActiveDataProvider([
            'query' => $modelClass::find()
        ]);
    }    
}