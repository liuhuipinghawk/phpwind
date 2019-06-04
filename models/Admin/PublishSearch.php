<?php

namespace app\models\Admin;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Admin\Publish;

/**
 * PublishSearch represents the model behind the search form about `app\models\Admin\Publish`.
 */
class PublishSearch extends Publish
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['publish_id', 'house_id', 'region_id', 'subway_id', 'age', 'deco_id', 'orien_id', 'status', 'is_del', 'publish_time', 'publish_user'], 'integer'],
            [['price', 'space'], 'number'],
            [['floor', 'house_desc', 'address', 'person', 'person_tel'], 'safe'],
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
        $query = Publish::find();

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
            'publish_id' => $this->publish_id,
            'house_id' => $this->house_id,
            'region_id' => $this->region_id,
            'subway_id' => $this->subway_id,
            'price' => $this->price,
            'space' => $this->space,
            'age' => $this->age,
            'deco_id' => $this->deco_id,
            'orien_id' => $this->orien_id,
            'status' => $this->status,
            'is_del' => $this->is_del,
            'publish_time' => $this->publish_time,
            'publish_user' => $this->publish_user,
        ]);

        $query->andFilterWhere(['like', 'floor', $this->floor])
            ->andFilterWhere(['like', 'house_desc', $this->house_desc])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'person', $this->person])
            ->andFilterWhere(['like', 'person_tel', $this->person_tel]);

        return $dataProvider;
    }
}
