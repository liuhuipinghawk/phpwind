<?php

namespace app\models\Admin;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Admin\HouseImg;

/**
 * HouseImgSearch represents the model behind the search form about `app\models\Admin\HouseImg`.
 */
class HouseImgSearch extends HouseImg
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['img_id', 'publish_id'], 'integer'],
            [['img_path', 'tag'], 'safe'],
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
        $query = HouseImg::find();

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
            'img_id' => $this->img_id,
            'publish_id' => $this->publish_id,
        ]);

        $query->andFilterWhere(['like', 'img_path', $this->img_path])
            ->andFilterWhere(['like', 'tag', $this->tag]);

        return $dataProvider;
    }
}
