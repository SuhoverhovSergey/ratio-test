<?php
namespace models;

use app\models\Task;

class TaskTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
        Task::updateAll(['status' => 0, 'retries' => 0, 'deffer' => null, 'finished' => null, 'result' => null]);
    }

    protected function _after()
    {
    }

    // tests
    public function testGetTaskForProcessingWithThreeMaxRetry()
    {
        $task = Task::getTaskForProcessing(3);
        $this->assertEquals(2971107, $task->id);

        Task::updateAll(['status' => 1], ['id' => 2971107]);

        $task = Task::getTaskForProcessing(3);
        $this->assertEquals(2971122, $task->id);
        $task->retries = 2;
        $task->save();

        $task = Task::getTaskForProcessing(3);
        $this->assertEquals(2971122, $task->id);
        $task->retries = 3;
        $task->save();

        $task = Task::getTaskForProcessing(3);
        $this->assertEquals(2971123, $task->id);
    }

    public function testGetTaskForProcessingWithZeroMaxRetry()
    {
        $task = Task::getTaskForProcessing(0);
        $this->assertEquals(null, $task);
    }

    public function testRunTaskSuccess()
    {
        $task = Task::getTaskForProcessing(3);
        $this->assertEquals(2971107, $task->id);
        $task->run();

        $this->assertEquals(1, $task->status);
        $this->assertEquals(1, $task->retries);
        $this->assertNotNull($task->finished);
        $this->assertEquals('{"zone":"mydomain.ru"}', $task->result);
    }

    public function testRunTaskUserException()
    {
        Task::updateAll(['status' => 1], ['id' => 2971107]);

        $task = Task::getTaskForProcessing(3);
        $this->assertEquals(2971122, $task->id);
        $task->run();

        $this->assertEquals(0, $task->status);
        $this->assertEquals(1, $task->retries);
        $this->assertNull($task->finished);
        $this->assertEquals('User exception error', $task->result);
        $this->assertNotNull($task->deffer);
    }

    public function testRunFatalException()
    {
        Task::updateAll(['status' => 1], ['id' => [2971107, 2971122, 2971123]]);

        $task = Task::getTaskForProcessing(3);
        $this->assertEquals(2971187, $task->id);
        $task->run();

        $this->assertEquals(1, $task->retries);
        $this->assertEquals(2, $task->status);
    }
}