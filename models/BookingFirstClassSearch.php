<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BookingFirstClass;

/**
 * BookingFirstClassSearch represents the model behind the search form of `app\models\BookingFirstClass`.
 */
class BookingFirstClassSearch extends BookingFirstClass
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_booking_first_class', 'user_id', 'dance_direction_id'], 'integer'],
            [['datetime', 'status'], 'safe'],
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
        $query = BookingFirstClass::find();

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
            'id_booking_first_class' => $this->id_booking_first_class,
            'user_id' => $this->user_id,
            'dance_direction_id' => $this->dance_direction_id,
            'datetime' => $this->datetime,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
