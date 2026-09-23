<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%empresa}}`.
 */
class m260923_105726_create_empresa_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%empresa}}', [
            'id' => $this->primaryKey(),
            'razao_social' => $this->string()->notNull(),
            'nome_fantasia' => $this->string()->notNull(),
            'cnpj' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'telefone' => $this->string()->notNull(),
            'status' => $this->boolean()->notNull()->defaultValue(true),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%empresa}}');
    }
}
