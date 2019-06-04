<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Equipment;

/**
 * EquipmentSearch represents the model behind the search form about `app\models\Equipment`.
 */
class EquipmentSearch extends Equipment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['equipment_id', 'pid', 'create_time', 'update_time','house_id'], 'integer'],
            [['equipment_name', 'thumb', 'content'], 'safe'],
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
        $query = Equipment::find();

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
            'equipment_id' => $this->equipment_id,
            'pid' => $this->pid,
            'price' => $this->price,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'house_id' =>$this->house_id
        ]);

        $query->andFilterWhere(['like', 'equipment_name', $this->equipment_name])
            ->andFilterWhere(['like', 'thumb', $this->thumb])
            ->andFilterWhere(['like', 'house_id', $this->house_id])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
