<?php

namespace app\models\Admin;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Admin\InspectionArea;

/**
 * InspectionAreaSearch represents the model behind the search form about `app\models\Admin\InspectionArea`.
 */
class InspectionAreaSearch extends InspectionArea
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area_id', 'parent_id'], 'integer'],
            [['area_name'], 'safe'],
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
        $query = InspectionArea::find();

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
            'area_id' => $this->area_id,
            'parent_id' => $this->parent_id,
        ]);

        $query->andFilterWhere(['like', 'area_name', $this->area_name]);

        return $dataProvider;
    }
}
