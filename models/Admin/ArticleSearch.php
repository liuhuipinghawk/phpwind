<?php

namespace app\models\Admin;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Admin\Article;

/**
 * ArticleSearch represents the model behind the search form about `app\models\Admin\Article`.
 */
class ArticleSearch extends Article
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['articleId', 'cateId', 'houseId', 'status', 'stars'], 'integer'],
            [['adminName', 'headImg', 'thumb', 'content', 'title', 'createTime', 'updateTime'], 'safe'],
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
        $session = \Yii::$app->session;
        $list = explode(',',$session['admin']['house_ids']);
        $query = Article::find()->where(['in','houseId',$list])->orWhere(['houseId'=>0]);

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
            'articleId' => $this->articleId,
            'cateId' => $this->cateId,
            'houseId' => $this->houseId,
            'status' => $this->status,
            'stars' => $this->stars,
        ]);

        $query->andFilterWhere(['like', 'adminName', $this->adminName])
            ->andFilterWhere(['like', 'headImg', $this->headImg])
            ->andFilterWhere(['like', 'thumb', $this->thumb])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'createTime', $this->createTime])
            ->andFilterWhere(['like', 'updateTime', $this->updateTime])->orderBy('createTime desc');
        return $dataProvider;
    }
}
