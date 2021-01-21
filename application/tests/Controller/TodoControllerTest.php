<?php

namespace App\Tests;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TodoControllerTest extends WebTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->client->disableReboot();

        $this->entityManager = $this->client->getContainer()->get('doctrine.orm.entity_manager');
        $this->entityManager->beginTransaction();
        $this->entityManager->getConnection()->setAutoCommit(false);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->rollback();
        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }

    public function testIndex()
    {
        $crawler = $this->client->request('GET', '/todo');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'My To do List');
    }

    public function testCreateTask()
    {
        $crawler = $this->client->request('GET', '/todo');

        $form = $crawler->selectButton('Add a Task')->form([
            'title' => 'test task'
        ]);
        $this->client->submit($form);

        $task = $this->entityManager->getRepository(Task::class)->findOneBy(['title'=>'test task']);

        $this->assertNotNull($task);
        $this->assertSame('test task', $task->getTitle());
    }
}
