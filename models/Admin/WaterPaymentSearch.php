<?php

namespace app\models\Admin;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Admin\WaterPayment;

/**
 * WaterPaymentSearch represents the model behind the search form about `app\models\WaterPayment`.
 */
class WaterPaymentSearch extends WaterPayment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id', 'account_id', 'water_consumption', 'create_time', 'status', 'water_type', 'water_time'], 'integer'],
            [['order_sn', 'trade_no'], 'safe'],
            [['water_fee'], 'number'],
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
        $query = WaterPayment::find();

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
            'order_id' => $this->order_id,
            'user_id' => $this->user_id,
            'account_id' => $this->account_id,
            'water_consumption' => $this->water_consumption,
            'create_time' => $this->create_time,
            'water_fee' => $this->water_fee,
            'status' => $this->status,
            'water_type' => $this->water_type,
            'water_time' => $this->water_time,
        ]);

        $query->andFilterWhere(['like', 'order_sn', $this->order_sn])
            ->andFilterWhere(['like', 'trade_no', $this->trade_no]);

        return $dataProvider;
    }
}
