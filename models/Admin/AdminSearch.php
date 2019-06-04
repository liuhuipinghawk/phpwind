<?php

namespace app\models\Admin;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Admin\Admin;

/**
 * AdminSearch represents the model behind the search form about `app\models\Admin\Admin`.
 */
class AdminSearch extends Admin
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['adminid'], 'integer'],
            [['adminuser', 'adminpass', 'adminemail', 'logintime', 'loginip', 'createtime'], 'safe'],
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
        $query = Admin::find();

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
            'adminid' => $this->adminid,
        ]);

        $query->andFilterWhere(['like', 'adminuser', $this->adminuser])
            ->andFilterWhere(['like', 'adminpass', $this->adminpass])
            ->andFilterWhere(['like', 'adminemail', $this->adminemail])
            ->andFilterWhere(['like', 'logintime', $this->logintime])
            ->andFilterWhere(['like', 'loginip', $this->loginip])
            ->andFilterWhere(['like', 'createtime', $this->createtime]);

        return $dataProvider;
    }
}
