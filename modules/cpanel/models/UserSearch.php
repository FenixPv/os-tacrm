<?php

namespace app\modules\cpanel\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\user\models\Users;

/**
 * UserSearch represents the model behind the search form of `app\modules\user\models\Users`.
 */
class UserSearch extends Users
{
    public $userRole;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['login', 'email_confirm_token', 'password_hash', 'password_reset_token', 'email', 'userRole'], 'safe'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Users::find()->joinWith([
            'userRole'
        ]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'login',
                    'email',
                    'status',
                    'userRole' => [
                        'asc' => [ 'auth_assignment.item_name' => SORT_ASC ],
                        'desc' => [ 'auth_assignment.item_name' => SORT_DESC ],
                    ],
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id'         => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status'     => $this->status,
        ]);

        $query->andFilterWhere(['like', 'login', $this->login])
            ->andFilterWhere(['like', 'email_confirm_token', $this->email_confirm_token])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'item_name', $this->userRole]);

        return $dataProvider;
    }
}
