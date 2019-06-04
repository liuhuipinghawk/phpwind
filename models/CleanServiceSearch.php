<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CleanService;

/**
 * CleanServiceSearch represents the model behind the search form about `app\models\CleanService`.
 */
class CleanServiceSearch extends CleanService
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['clean_id', 'pid', 'create_time', 'update_time'], 'integer'],
            [['clean_name'], 'safe'],
            [['price'], 'number'],
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
        $query = CleanService::find();

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
            'clean_id' => $this->clean_id,
            'pid' => $this->pid,
            'price' => $this->price,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'clean_name', $this->clean_name]);

        return $dataProvider;
    }
}
