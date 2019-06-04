<?php

namespace app\models\Admin;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Admin\Maintenancetype;

/**
 * MaintenancetypeSearch represents the model behind the search form about `app\models\Admin\Maintenancetype`.
 */
class MaintenancetypeSearch extends Maintenancetype
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parentId'], 'integer'],
            [['housename', 'createtime', 'updatetime'], 'safe'],
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
        $query = Maintenancetype::find();

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
            'parentId' => $this->parentId,
        ]);

        $query->andFilterWhere(['like', 'housename', $this->housename])      
            ->andFilterWhere(['like', 'createtime', $this->createtime])
            ->andFilterWhere(['like', 'updatetime', $this->updatetime]);

        return $dataProvider;
    }
}
