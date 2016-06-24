<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "task".
 *
 * @property integer $id
 * @property integer $account_id
 * @property string $created
 * @property string $deffer
 * @property integer $type
 * @property string $task
 * @property string $action
 * @property string $data
 * @property integer $status
 * @property integer $retries
 * @property string $finished
 * @property string $result
 */
class Task extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task';
    }

    public static function getTaskForProcessing($retry)
    {
        return Task::find()
            ->where(['status' => 0])
            ->andWhere(['<', 'retries', $retry])
            ->andWhere(['or',
                ['is', 'deffer', new Expression('null')],
                ['<=', 'deffer', date('Y-m-d H:i:s')],
            ])
            ->orderBy('deffer ASC, created ASC')
            ->limit(1)->one();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id', 'type', 'status', 'retries'], 'integer'],
            [['created', 'deffer', 'finished'], 'safe'],
            [['data', 'result'], 'string'],
            [['task', 'action'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account_id' => 'Account ID',
            'created' => 'Created',
            'deffer' => 'Deffer',
            'type' => 'Type',
            'task' => 'Task',
            'action' => 'Action',
            'data' => 'Data',
            'status' => 'Status',
            'retries' => 'Retries',
            'finished' => 'Finished',
            'result' => 'Result',
        ];
    }
}
