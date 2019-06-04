<?php

namespace app\models\Admin;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Admin\Decoration;

/**
 * DecorationSearch represents the model behind the search form about `app\models\Admin\Decoration`.
 */
class DecorationSearch extends Decoration
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deco_id'], 'integer'],
            [['deco_name'], 'safe'],
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
        $query = Decoration::find();

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
            'deco_id' => $this->deco_id,
        ]);

        $query->andFilterWhere(['like', 'deco_name', $this->deco_name]);

        return $dataProvider;
    }
}
