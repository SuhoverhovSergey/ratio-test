<?php

namespace app\commands;

use yii\console\Controller;
use app\models\Task;

class TaskController extends Controller
{
    // максимальное количество попыток выполнения задачи
    const TASK_RETRY_LIMIT = 3;

    public function actionIndex()
    {
        $this->stdout("Start task handler\n");

        while (true) {
            /** @var Task $task */
            $task = Task::getTaskForProcessing(self::TASK_RETRY_LIMIT);

            if ($task) {
                $task->run();
                $this->stdout("[" . date('Y-m-d H:i:s') . "] #$task->id $task->task -> $task->action : $task->result\n");
            }
        }

        $this->stdout("End!\n");
    }
}
