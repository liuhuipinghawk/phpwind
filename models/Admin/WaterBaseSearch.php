<?php

namespace app\models\Admin;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Admin\WaterBase;

/**
 * WaterBaseSearch represents the model behind the search form about `app\models\WaterBase`.
 */
class WaterBaseSearch extends WaterBase
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'house_id', 'seat_id', 'meter_number', 'water_type', 'create_time', 'status'], 'integer'],
            [['owner_name', 'installation_site', 'this_month', 'end_month', 'month_dosage'], 'safe'],
            [['monovalent', 'month_amount'], 'number'],
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
        $query = WaterBase::find();
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'water_base.id' => $this->id,
            'water_base.meter_number' => $this->meter_number,
            'water_base.monovalent' => $this->monovalent,
            'water_base.month_amount' => $this->month_amount,
            'water_base.water_type' => $this->water_type,
            'water_base.create_time' => $this->create_time,
            'water_base.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'water_base.owner_name', $this->owner_name])
            ->andFilterWhere(['like', 'water_base.this_month', $this->this_month])
            ->andFilterWhere(['like', 'water_base.end_month', $this->end_month])
            ->andFilterWhere(['like', 'water_base.month_dosage', $this->month_dosage]);

        return $dataProvider;
    }
}
