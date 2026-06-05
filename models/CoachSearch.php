<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Coach;

/**
 * CoachSearch represents the model behind the search form of `app\models\Coach`.
 */
class CoachSearch extends Coach
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_coach', 'dance_direction_id'], 'integer'],
            [['fio', 'description', 'foto'], 'safe'],
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
        $query = Coach::find();

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
            'id_coach' => $this->id_coach,
            'dance_direction_id' => $this->dance_direction_id,
        ]);

        $query->andFilterWhere(['like', 'fio', $this->fio])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'foto', $this->foto]);

        return $dataProvider;
    }
}
