<?php

namespace app\modules\bill\models;

use app\models\Entity;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\bill\models\BillCategory;

/**
 * BillCategorySearch represents the model behind the search form about `app\modules\bill\models\BillCategory`.
 */
class BillCategorySearch extends BillCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'deleted'], 'integer'],
            [['name', 'created_at'], 'safe'],
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
        $query = BillCategory::find()->where(['deleted' => Entity::NOT_DELETED]);

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
            'created_at' => $this->created_at,
            'deleted' => $this->deleted,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
