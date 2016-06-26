<?php

use yii\db\Migration;

/**
 * Handles the creation for table `task`.
 */
class m160626_220338_create_task extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('task', [
            'id' => $this->primaryKey(),
            'account_id' => $this->integer()->unsigned()->defaultValue(null),
            'created' => $this->dateTime()->defaultValue(null),
            'deffer' => $this->dateTime()->defaultValue(null),
            'type' => $this->integer(2)->defaultValue(null),
            'task' => $this->string(45)->defaultValue(null),
            'action' => $this->string(45)->defaultValue(null),
            'data' => $this->text(),
            'status' => $this->integer(2)->defaultValue(null),
            'retries' => $this->integer(2)->defaultValue(null),
            'finished' => $this->dateTime()->defaultValue(null),
            'result' => $this->text(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('task');
    }
}
