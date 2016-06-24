<?php

namespace app\commands;

use yii\helpers\Json;
use yii\console\Controller;
use app\models\Task;
use Plp\Task\UserException;
use Plp\Task\FatalException;

class TaskController extends Controller
{
    // максимальное количество попыток выполнения задачи
    const TASK_RETRY_LIMIT = 3;
    // статус задачи "невозможно выполнить"
    const TASK_STATUS_IMPOSSIBLE = 2;

    public function actionIndex()
    {
        $this->stdout("Start task handler\n");

        while (true) {
            /** @var Task $task */
            $task = Task::getTaskForProcessing(self::TASK_RETRY_LIMIT);

            if ($task) {
                $date = date('Y-m-d H:i:s');
                try {
                    $result = call_user_func(
                        ['\Plp\Task\\' . ucfirst($task->task), $task->action], Json::decode($task->data)
                    );
                    $task->result = Json::encode($result);
                    $task->finished = $date;
                    $task->status = 1;
                } catch (UserException $e) {
                    $task->result = $e->getMessage();
                    $task->deffer = date('Y-m-d H:i:s', strtotime('+5 minutes'));
                } catch (FatalException $e) {
                    $task->status = self::TASK_STATUS_IMPOSSIBLE;
                    $message = $e->getMessage();
                    $trace = $e->getTraceAsString();
                    error_log($message . "\n" . $trace);
                }
                $task->retries++;
                $task->save();

                $this->stdout("[$date] #$task->id $task->task -> $task->action : $task->result\n");
            }
        }

        $this->stdout("End!\n");
    }
}
