<?php

declare(strict_types=1);

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class EmpresaSearch extends Empresa
{
    public function rules(): array
    {
        return [
            [['id', 'status'], 'integer'],
            [['razao_social', 'nome_fantasia', 'cnpj', 'email', 'telefone', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios(): array
    {
        return Model::scenarios();
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = Empresa::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $cnpj = $this->cnpj !== null && $this->cnpj !== ''
            ? preg_replace('/\D+/', '', (string) $this->cnpj)
            : $this->cnpj;

        $query->andFilterWhere(['like', 'razao_social', $this->razao_social])
            ->andFilterWhere(['like', 'nome_fantasia', $this->nome_fantasia])
            ->andFilterWhere(['like', 'cnpj', $cnpj])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'telefone', $this->telefone]);

        return $dataProvider;
    }
}
