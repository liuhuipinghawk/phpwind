<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Furniture;

/**
 * FurnitureSearch represents the model behind the search form about `app\models\Furniture`.
 */
class FurnitureSearch extends Furniture
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['furniture_id', 'pid', 'create_time', 'update_time'], 'integer'],
            [['furniture_name', 'thumb', 'content'], 'safe'],
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
        $query = Furniture::find();

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
            'furniture_id' => $this->furniture_id,
            'price' => $this->price,
            'pid' => $this->pid,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'furniture_name', $this->furniture_name])
            ->andFilterWhere(['like', 'thumb', $this->thumb])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
