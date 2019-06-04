<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Flower;

/**
 * FlowerSearch represents the model behind the search form about `app\models\Flower`.
 */
class FlowerSearch extends Flower
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['flower_id', 'pid', 'shopping_method', 'effect_plants', 'Pot_type', 'green_implication', 'covering_area', 'position', 'create_time', 'update_time','house_id'], 'integer'],
            [['flower_name', 'content'], 'safe'],
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
        $query = Flower::find();

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
            'flower_id' => $this->flower_id,
            'pid' => $this->pid,
            'shopping_method' => $this->shopping_method,
            'effect_plants' => $this->effect_plants,
            'Pot_type' => $this->Pot_type,
            'green_implication' => $this->green_implication,
            'covering_area' => $this->covering_area,
            'position' => $this->position,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'house_id' =>$this->house_id
        ]);

        $query->andFilterWhere(['like', 'flower_name', $this->flower_name])
            ->andFilterWhere(['like', 'house_id', $this->house_id])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
