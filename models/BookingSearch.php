<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Bookings;

/**
 * BookingSearch represents the model behind the search form of `app\models\Bookings`.
 */
class BookingSearch extends Bookings
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_booking', 'user_id', 'hall_id'], 'integer'],
            [['date', 'time_slot', 'status', 'created_booking'], 'safe'],
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
        $query = Bookings::find();

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
            'id_booking' => $this->id_booking,
            'user_id' => $this->user_id,
            'hall_id' => $this->hall_id,
            'date' => $this->date,
            'created_booking' => $this->created_booking,
        ]);

        $query->andFilterWhere(['like', 'time_slot', $this->time_slot])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
