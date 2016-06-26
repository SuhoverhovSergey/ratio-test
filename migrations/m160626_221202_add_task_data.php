<?php

use yii\db\Migration;

class m160626_221202_add_task_data extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $rows = [
            [2971220, 70748, '2016-02-14 13:09:15', null, null, 'integration', 'process', '{\"integration_id\":3312,\"lead_id\":\"2999670\"}', 0, 0, null, null],
            [2971206, 80034, '2016-02-14 13:08:16', null, null, 'message', 'sms', '{\"number\":\"89111111119\",\"message\":\"Заявка с ru.ru\\nвячеслав \\n\"}', 0, 0, null, null],
            [2971187, 81259, '2016-02-14 13:06:42', null, null, 'account', 'bill', '{\"bill_id\":\"82029\"}',0, 0, null, null],
            [2971123, 9608, '2016-02-14 13:01:58', null, null, 'integration', 'process', '{\"integration_id\":2845,\"lead_id\":\"2999571\"}', 0, 0, null, null],
            [2971122, 9608, '2016-02-14 13:01:53', null, null, 'integration', 'process', '{\"integration_id\":2987,\"lead_id\":\"2999570\"}', 0, 0, null, null],
            [2971107, 83992, '2016-02-14 13:01:03', null, null, 'domain', 'addzone', '{\"domain\":\"mydomain.ru\"}', 0, 0, null, null],
        ];
        $this->batchInsert('task', [
            'id', 'account_id', 'created', 'deffer', 'type', 'task', 'action', 'data', 'status', 'retries', 'finished', 'result'
        ], $rows);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->delete('task');
    }
}
