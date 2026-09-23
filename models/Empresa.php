<?php

namespace app\models;

use yii\db\ActiveRecord;

class Empresa extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'empresa';
    }
}