<?php

namespace App\Tests\Entity;


use App\Entity\Task;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function testTitle()
    {
        $task = new Task();

        $task->setTitle('Test');

        $this->assertEquals('Test', $task->getTitle());
    }

    public function testStatus()
    {
        $task = new Task();

        $task->setStatus(true);

        $this->assertEquals(true, $task->getStatus());
    }
}
