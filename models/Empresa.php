<?php

declare(strict_types=1);

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $razao_social
 * @property string $nome_fantasia
 * @property string $cnpj
 * @property string $email
 * @property string $telefone
 * @property int|bool $status
 * @property string $created_at
 * @property string $updated_at
 */
class Empresa extends ActiveRecord
{
    public const STATUS_INATIVA = 0;
    public const STATUS_ATIVA = 1;

    public static function tableName(): string
    {
        return 'empresa';
    }

    public function rules(): array
    {
        return [
            [['razao_social', 'nome_fantasia', 'cnpj', 'email', 'telefone'], 'trim'],
            [['razao_social', 'nome_fantasia', 'cnpj', 'email', 'telefone', 'status'], 'required'],
            [['razao_social', 'nome_fantasia'], 'string', 'max' => 255],
            ['cnpj', 'string', 'max' => 18],
            ['cnpj', 'validateCnpj'],
            ['cnpj', 'unique', 'targetAttribute' => 'cnpj', 'message' => 'Já existe uma empresa com este CNPJ.'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['telefone', 'string', 'max' => 20],
            ['status', 'boolean'],
            ['status', 'default', 'value' => self::STATUS_ATIVA],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'razao_social' => 'Razão Social',
            'nome_fantasia' => 'Nome Fantasia',
            'cnpj' => 'CNPJ',
            'email' => 'E-mail',
            'telefone' => 'Telefone',
            'status' => 'Status',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
        ];
    }

    public function beforeValidate(): bool
    {
        if (!parent::beforeValidate()) {
            return false;
        }

        if ($this->cnpj !== null && $this->cnpj !== '') {
            $this->cnpj = preg_replace('/\D+/', '', (string) $this->cnpj);
        }

        return true;
    }

    public function validateCnpj(string $attribute): void
    {
        $cnpj = preg_replace('/\D+/', '', (string) $this->$attribute);

        if (strlen($cnpj) !== 14 || preg_match('/^(\d)\1{13}$/', $cnpj)) {
            $this->addError($attribute, 'Informe um CNPJ válido.');
            return;
        }

        $weights1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $weights2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $sum += (int) $cnpj[$i] * $weights1[$i];
        }
        $digit1 = ($sum % 11) < 2 ? 0 : 11 - ($sum % 11);

        if ((int) $cnpj[12] !== $digit1) {
            $this->addError($attribute, 'Informe um CNPJ válido.');
            return;
        }

        $sum = 0;
        for ($i = 0; $i < 13; $i++) {
            $sum += (int) $cnpj[$i] * $weights2[$i];
        }
        $digit2 = ($sum % 11) < 2 ? 0 : 11 - ($sum % 11);

        if ((int) $cnpj[13] !== $digit2) {
            $this->addError($attribute, 'Informe um CNPJ válido.');
        }
    }

    public function getCnpjFormatado(): string
    {
        $cnpj = preg_replace('/\D+/', '', (string) $this->cnpj);

        if (strlen($cnpj) !== 14) {
            return (string) $this->cnpj;
        }

        return sprintf(
            '%s.%s.%s/%s-%s',
            substr($cnpj, 0, 2),
            substr($cnpj, 2, 3),
            substr($cnpj, 5, 3),
            substr($cnpj, 8, 4),
            substr($cnpj, 12, 2),
        );
    }

    public function getStatusLabel(): string
    {
        return (int) $this->status === self::STATUS_ATIVA ? 'Ativa' : 'Inativa';
    }

    public static function getStatusList(): array
    {
        return [
            self::STATUS_ATIVA => 'Ativa',
            self::STATUS_INATIVA => 'Inativa',
        ];
    }
}
