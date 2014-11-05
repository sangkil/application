<?php

namespace app\models\inventory\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\inventory\GoodMovement as GoodMovementModel;

/**
 * GoodMovement represents the model behind the search form about `app\models\inventory\GoodMovement`.
 */
class GoodMovement extends GoodMovementModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'reff_type', 'reff_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['number', 'date', 'description', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = GoodMovementModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'date' => $this->date,
            'type' => $this->type,
            'reff_type' => $this->reff_type,
            'reff_id' => $this->reff_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
