<?php

namespace app\models\Admin;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Admin\WyOrder;

/**
 * WyOrderSearch represents the model behind the search form about `app\models\Admin\WyOrder`.
 */
class WyOrderSearch extends WyOrder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wyorderId', 'houseId', 'userId', 'status'], 'integer'],
            [['userName', 'Address', 'content', 'thumb', 'orderTime', 'ContactPersion', 'ContactNumber'], 'safe'],
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
        $query = WyOrder::find();

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
            'wyorderId' => $this->wyorderId,
            'houseId' => $this->houseId,
            'userId' => $this->userId,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'userName', $this->userName])
            ->andFilterWhere(['like', 'Address', $this->Address])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'thumb', $this->thumb])
            ->andFilterWhere(['like', 'orderTime', $this->orderTime])
            ->andFilterWhere(['like', 'ContactPersion', $this->ContactPersion])
            ->andFilterWhere(['like', 'ContactNumber', $this->ContactNumber]);

        return $dataProvider;
    }
}
