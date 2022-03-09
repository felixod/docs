<?php

namespace backend\models;

use backend\models\FileUser;
use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * FileUserSearch represents the model behind the search form of `backend\models\FileUser`.
 */
class FileUserSearch extends FileUser
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_file_user', 'id_file'], 'integer'],
            [['full_name', 'email', 'confirm', 'signature', 'date_confirm'], 'safe'],
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
    public function search($params, $id_file)
    {
        $query = FileUser::find()->where('id_file=' . $id_file);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 30,

            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_file_user' => $this->id_file_user,
            'id_file' => $this->id_file,
            'date_confirm' => $this->date_confirm,
        ]);

        $query->andFilterWhere(['like', 'full_name', $this->full_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'confirm', $this->confirm])
            ->andFilterWhere(['like', 'signature', $this->signature]);


        return $dataProvider;
    }

    /**
     * @param $params
     * @param $institut
     * @return array
     */
    public function search_2($params, $institut)
    {
        $k = 0;

        foreach ($institut as $item) {


//            $query = FileUser::find()->where('id_file=' . $item['id_file']);
            $query = \Yii::$app->db->createCommand('SELECT 
                                                            file_user.id_file_user,
                                                            file_user.id_file,
                                                            file_user.full_name,
                                                            file_user.email,
                                                            file_user.confirm,
                                                            file_user.signature,
                                                            file_user.date_confirm,
                                                            org_struktura.name_struktura
                                                        FROM
                                                            file_user, file,org_struktura
                                                        WHERE
                                                            file.id_file = file_user.id_file 
                                                        AND 
                                                            file.id_struktur = org_struktura.id_struktura
                                                        AND 
                                                            file_user.id_file ='.$item['id_file']);
            $f = $query->queryAll();

            foreach ($f as $key) {
                $institut[$k] = [
                    'id_file_user' => $key['id_file_user'],
                    'id_file' => $key['id_file'],
                    'full_name' => $key['full_name'],
                    'email' => $key['email'],
                    'confirm' => $key['confirm'],
                    'signature' => $key['signature'],
                    'date_confirm' => $key['date_confirm'],
                    'name_struktura' => $key['name_struktura'],
                ];
                $k++;
            }
        }

        $grouped = array();
        $groupBy = 'id_file';
        foreach ($institut as $v) {
            $key = $v[$groupBy];
            if (!array_key_exists($key, $grouped))
                $grouped[$key] = array($v);
            else
                $grouped[$key][] = $v;
        }

        return $grouped;
    }

}
