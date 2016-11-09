<?php

namespace app\models\tables;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\tables\Mailing;

/**
 * MailingSearch represents the model behind the search form about `app\models\tables\Mailing`.
 */
class MailingSearch extends Mailing
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'mail_template_id', 'status'], 'integer'],
            [['placeholders', 'created_at', 'date_send'], 'safe'],
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
        $query = Mailing::find();

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
            'user_id' => $this->user_id,
            'mail_template_id' => $this->mail_template_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'date_send' => $this->date_send,
        ]);

        $query->andFilterWhere(['like', 'placeholders', $this->placeholders]);

        return $dataProvider;
    }
}
