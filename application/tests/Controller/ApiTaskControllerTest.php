<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiTaskControllerTest extends WebTestCase
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

    public function testIndex(): void
    {

        $this->client->request('GET', '/tasks/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testShow(): void
    {
        $this->client->request('GET', '/tasks/1');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testCreate(): void
    {
        $this->client->request('POST', '/tasks/', ['title' => 'test']);

        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
    }

    public function testCreateBadRequestError(): void
    {
        $this->client->request('POST', '/tasks/');

        $this->assertEquals(400, $this->client->getResponse()->getStatusCode());
    }

    public function testUpdateBadRequestError(): void
    {
        $this->client->request('PUT', '/tasks/1');

        $this->assertEquals(400, $this->client->getResponse()->getStatusCode());
    }
}
