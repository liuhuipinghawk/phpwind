<?php

namespace app\models\Admin;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Admin\HouseAccess;

/**
 * HouseAccessSearch represents the model behind the search form about `app\models\Admin\HouseAccess`.
 */
class HouseAccessSearch extends HouseAccess
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'house_id'], 'integer'],
            [['access'], 'safe'],
            [['home'], 'safe'],
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
        $query = HouseAccess::find();

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
        ]);

        $query->andFilterWhere(['like', 'access', $this->access]);
        $query->andFilterWhere(['like', 'home', $this->home]);
        return $dataProvider;
    }
}
