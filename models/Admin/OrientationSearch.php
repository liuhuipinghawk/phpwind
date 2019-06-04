<?php

namespace app\models\Admin;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Admin\Orientation;

/**
 * OrientationSearch represents the model behind the search form about `app\models\Admin\Orientation`.
 */
class OrientationSearch extends Orientation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['orien_id'], 'integer'],
            [['orien_name'], 'safe'],
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
        $query = Orientation::find();

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
            'orien_id' => $this->orien_id,
        ]);

        $query->andFilterWhere(['like', 'orien_name', $this->orien_name]);

        return $dataProvider;
    }
}
