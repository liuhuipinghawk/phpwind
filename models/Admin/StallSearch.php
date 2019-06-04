<?php

namespace app\models\Admin;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Admin\Stall;

/**
 * StallSearch represents the model behind the search form about `app\models\Admin\Stall`.
 */
class StallSearch extends Stall
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'house_id', 'stall_num', 'user_id', 'time'], 'integer'],
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
        $query = Stall::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'house_id' => $this->house_id,
            'stall_num' => $this->stall_num,
            'user_id' => $this->user_id,
            'time' => $this->time,
        ]);

        return $dataProvider;
    }
}
