<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\FileType;

/**
 * FileTypeSearch represents the model behind the search form of `backend\models\FileType`.
 */
class FileTypeSearch extends FileType
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_type_file'], 'integer'],
            [['name_type_file'], 'safe'],
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
        $query = FileType::find();

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
            'id_type_file' => $this->id_type_file,
        ]);

        $query->andFilterWhere(['like', 'name_type_file', $this->name_type_file]);

        return $dataProvider;
    }
}
