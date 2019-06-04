<?php

namespace app\models\Admin;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Admin\VersionUpgrade;

/**
 * VersionUpgradeSearch represents the model behind the search form about `app\models\Admin\VersionUpgrade`.
 */
class VersionUpgradeSearch extends VersionUpgrade
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'status', 'create_time', 'update_time'], 'integer'],
            [['app_id', 'version_code', 'apk_url', 'upgrade_point'], 'safe'],
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
        $query = VersionUpgrade::find();

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
            'type' => $this->type,
            'status' => $this->status,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'app_id', $this->app_id])
            ->andFilterWhere(['like', 'version_code', $this->version_code])
            ->andFilterWhere(['like', 'apk_url', $this->apk_url])
            ->andFilterWhere(['like', 'upgrade_point', $this->upgrade_point]);

        return $dataProvider;
    }
}
