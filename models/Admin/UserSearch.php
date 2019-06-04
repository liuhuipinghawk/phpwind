<?php

namespace app\models\Admin;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Admin\User;

/**
 * UserSearch represents the model behind the search form about `app\models\Admin\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'HouseId', 'Seat', 'Status', 'Cases', 'Department', 'Position', 'Maintenancetype'], 'integer'],
            [['Tell', 'PassWord', 'CreateTime', 'UpdateTime', 'LoginTime', 'HeaderImg', 'NickName', 'Email', 'TrueName', 'Address', 'IdCard', 'IdCardOver', 'WorkCard', 'Company'], 'safe'],
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
        $query = User::find();

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
            'HouseId' => $this->HouseId,
            'Seat' => $this->Seat,
            'Status' => $this->Status,
            'Cases' => $this->Cases,
            'Department' => $this->Department,
            'Position' => $this->Position,
            'Maintenancetype' => $this->Maintenancetype,
        ]);

        $query->andFilterWhere(['like', 'Tell', $this->Tell])
            ->andFilterWhere(['like', 'PassWord', $this->PassWord])
            ->andFilterWhere(['like', 'CreateTime', $this->CreateTime])
            ->andFilterWhere(['like', 'UpdateTime', $this->UpdateTime])
            ->andFilterWhere(['like', 'LoginTime', $this->LoginTime])
            ->andFilterWhere(['like', 'HeaderImg', $this->HeaderImg])
            ->andFilterWhere(['like', 'NickName', $this->NickName])
            ->andFilterWhere(['like', 'Email', $this->Email])
            ->andFilterWhere(['like', 'TrueName', $this->TrueName])
            ->andFilterWhere(['like', 'Address', $this->Address])
            ->andFilterWhere(['like', 'IdCard', $this->IdCard])
            ->andFilterWhere(['like', 'IdCardOver', $this->IdCardOver])
            ->andFilterWhere(['like', 'WorkCard', $this->WorkCard])
            ->andFilterWhere(['like', 'Company', $this->Company]);

        return $dataProvider;
    }
}
