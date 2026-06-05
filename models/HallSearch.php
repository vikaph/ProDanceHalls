<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Hall;

/**
 * HallSearch represents the model behind the search form of `app\models\Hall`.
 */
class HallSearch extends Hall
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_hall'], 'integer'],
            [['title', 'description', 'foto', 'price', 'size'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Hall::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_hall' => $this->id_hall,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'foto', $this->foto])
            ->andFilterWhere(['like', 'price', $this->price])
            ->andFilterWhere(['like', 'size', $this->size]);

        return $dataProvider;
    }
}
