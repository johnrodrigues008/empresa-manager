<?php

use yii\db\Migration;

/**
 * Handles adding unique index to table `{{%empresa}}`.
 */
class m260923_111235_add_unique_index_to_empresa_cnpj extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-empresa-cnpj-unique',
            '{{%empresa}}',
            'cnpj',
            true,
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-empresa-cnpj-unique', '{{%empresa}}');
    }
}
