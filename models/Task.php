<?php

namespace app\models;

use Yii;
use yii\helpers\Json;
use yii\db\Expression;
use yii\db\ActiveRecord;
use Plp\Task\UserException;
use Plp\Task\FatalException;

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
    // статус задачи "невозможно выполнить"
    const TASK_STATUS_IMPOSSIBLE = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * @param $maxRetry
     * @return array|null|Task
     */
    public static function getTaskForProcessing($maxRetry)
    {
        return Task::find()
            ->where(['status' => 0])
            ->andWhere(['<', 'retries', $maxRetry])
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

    public function run()
    {
        try {
            $result = call_user_func(
                ['\Plp\Task\\' . ucfirst($this->task), $this->action], Json::decode($this->data)
            );
            $this->result = Json::encode($result);
            $this->finished = date('Y-m-d H:i:s');
            $this->status = 1;
        } catch (UserException $e) {
            $this->result = $e->getMessage();
            $this->deffer = date('Y-m-d H:i:s', strtotime('+5 minutes'));
        } catch (FatalException $e) {
            $this->status = self::TASK_STATUS_IMPOSSIBLE;
            $message = $e->getMessage();
            $trace = $e->getTraceAsString();
            error_log($message . "\n" . $trace);
        }
        $this->retries++;
        $this->save();
    }
}
